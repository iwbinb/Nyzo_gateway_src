import ast

import requests
import requests.auth
import base64
import multiprocessing
import time
import datetime
import json
import urllib.parse as urllib
import re
import math
import binascii
from hashlib import sha256
from urllib.parse import urlparse
# from MYSQL_SELECT_GATE import mysql_select
import classes.GATE_MYSQL_CONFIG as MYSQL

# exit()


def myconverter(o):
    if isinstance(o, datetime.datetime):
        return o.__str__()


class QtradeAuth(requests.auth.AuthBase):
    def __init__(self, key):
        self.key_id, self.key = key.split(":")

    def __call__(self, req):
        # modify and return the request
        timestamp = str(int(time.time()))
        url_obj = urlparse(req.url)

        request_details = req.method + "\n"
        request_details += url_obj.path + url_obj.params + "\n"
        request_details += timestamp + "\n"
        if req.body:
            request_details += req.body + "\n"
        else:
            request_details += "\n"
        request_details += self.key
        hsh = sha256(request_details.encode("utf8")).digest()
        signature = base64.b64encode(hsh)
        req.headers.update({
            "Authorization": "HMAC-SHA256 {}:{}".format(self.key_id, signature.decode("utf8")),
            "HMAC-Timestamp": timestamp
        })
        return req


api = requests.Session()
api.auth = QtradeAuth("")


def mysql_select(fields, table, filter_key, filter_value, sorted_by, limit, sorted_m):
    parsed_fields = fields

    executable_sql = "SELECT {} FROM {}".format(parsed_fields, table)
    if filter_key != 'none' and filter_value != 'none':
        executable_sql = executable_sql + \
            " WHERE {} = '{}'".format(filter_key, filter_value)
    if sorted_by != 'none':
        executable_sql = executable_sql + \
            " ORDER BY {} {}".format(sorted_by, sorted_m)
    if limit != 'none':
        executable_sql = executable_sql + " LIMIT {}".format(limit)

    executable_dict_sql = "SELECT {} FROM {}.{} WHERE {}='{}' AND {}='{}'".format('COLUMN_NAME',
                                                                                  'INFORMATION_SCHEMA', 'COLUMNS',
                                                                                  'TABLE_SCHEMA', MYSQL.database,
                                                                                  'TABLE_NAME', table)
    results_list = []
    MYSQL.sql_pointer.execute(executable_sql)
    select_results = MYSQL.sql_pointer.fetchall()

    MYSQL.sql_pointer.execute(executable_dict_sql)
    dict_key_results = str(MYSQL.sql_pointer.fetchall())
    dict_key_results = list(re.findall(r"'(.*?)'", dict_key_results))

    dicts_list = []
    select_results = list(select_results)
    dicts_list.append({'total': len(select_results), 'amt_keys': len(
        dict_key_results), 'keys': str(dict_key_results)})
    for x in select_results:
        pos = select_results.index(x) + 1
        x = list(x)
        dict_test = {}
        for i in range(0, len(x)):
            key_value = dict_key_results[i]
            dict_test.update({key_value: x[i]})
        dicts_list.append(dict_test)
        results_list.append(x)
    results_json = json.dumps(dicts_list, default=myconverter)
    # print(dicts_list)

    if MYSQL.sql_pointer.rowcount > 0:
        # return ast.literal_eval(results_json)
        return json.loads(results_json)
    else:
        return ast.literal_eval('[{"total": 0}]')


def check_balance():
    res = api.get('https://api.qtrade.io/v1/user/balances').json()
    for i in res['data']['balances']:
        if i['currency'] == 'NYZO':
            return int(i['balance'])


def write_last_balance(bal):
    with open('x/last_action_balance.txt', 'w') as file:
        file.write(str(bal))


def determine_action_necessary():
    with open('x/last_action_balance.txt', 'r') as file:
        previous_balance = int(file.readline())
        current_balance = check_balance()

        if current_balance > previous_balance:
            write_last_balance(current_balance)
            log_to_file(
                101, 'Determined that action is necessary based on a positive balance change')
            return True
        elif current_balance < previous_balance:
            log_to_file(
                102, 'Determined that action is NOT necessary based on a negative balance change')
            return False
        elif current_balance == previous_balance:
            # this is not reported since it is far too common
            return False


def func_w_timeout(func_name, secs):
    p = multiprocessing.Process(target=func_name)
    p.start()
    p.join(secs)
    if p.is_alive():
        p.terminate()
        p.join()


def determine_deposit_confirmed(deposit_confirms, deposit_confirms_required, deposit_status, deposit_currency):
    if deposit_confirms >= deposit_confirms_required and deposit_status == 'credited' and deposit_currency == 'NYZO':
        return True
    else:
        return False


def determine_amount_fulfilled(deposit_sender_tag, deposit_amount, db_entries_list):
    for x in db_entries_list:
        if x[1] == deposit_sender_tag:
            log_to_file(777, (str(
                x[0]) + str(x[1]) + str(deposit_sender_tag) + str(deposit_amount) + str(db_entries_list)))
            if int(float(x[0])) <= int(float(deposit_amount)):
                log_to_file(
                    103, 'Determined that the deposit_amount covers the payment_cost')
                return True
    return False


def update_product_shrinked(new_amount_left, new_delivery, product_id):
    print(new_delivery)
    print(product_id)
    sql = "UPDATE products SET product_delivery='{}', amount_left='{}' WHERE product_id='{}'".format(
        new_delivery, new_amount_left, product_id)
    MYSQL.sql_pointer.execute(sql)
    # res = MYSQL.sql_pointer.fetchall()
    MYSQL.my_db.commit()

    log_to_file(
        104, 'Successfully updated the product_delivery for ' + str(product_id))
    return True
    # return False


def update_payment_delivery(db_entries_list, deposit_sender_tag):
    # db_entries_list:
    # db_payment_cost[0], db_payment_tag, db_product_id, db_qtrade_id, db_tx_id
    # db_product_type, db_amount_left, db_product_delivery[7]
    new_delivery_remainder = ''
    new_amount_left = '0'
    relevant_list = [i for i in db_entries_list if i[1] == deposit_sender_tag]
    if len(relevant_list) <= 0:
        return False

    relevant_list = relevant_list[0]
    if int(relevant_list[6]) > 0:
        new_amount_left = str(int(relevant_list[6]) - 1)
    else:
        new_amount_left = '0'

    if relevant_list[5] == 1:
        sql = "UPDATE payments SET product_delivered='{}' WHERE payment_tag='{}'".format(
            urllib.quote(relevant_list[7], safe=''), relevant_list[1])
    elif relevant_list[5] == 2:
        delivery_list = str(relevant_list[7]).split('\n')
        sql = "UPDATE payments SET product_delivered='{}' WHERE payment_tag='{}'".format(
            delivery_list[0], relevant_list[1])
        delivery_list.pop(0)
        new_delivery_list = delivery_list
        for i in new_delivery_list:
            new_delivery_remainder = new_delivery_remainder + i + '\n'
    else:
        log_to_file(
            44, 'ERROR! Was unable to update determine producttype ' + relevant_list[1])
        return False

    MYSQL.sql_pointer.execute(sql)
    # res = MYSQL.sql_pointer.fetchall()
    MYSQL.my_db.commit()
    # if len(res) > 0:
    log_to_file(
        105, 'Updated the delivered product for payment_tag ' + relevant_list[1])
    print("New delivery remainder: " + new_delivery_remainder +
          " Length: " + str(len(new_delivery_remainder)))
    if len(new_delivery_remainder) > 1:
        update_product_shrinked(
            new_amount_left, new_delivery_remainder, relevant_list[2])
        log_to_file(
            106, 'Returning new_amount_left and the new_delivery remainder')
    else:
        if relevant_list[5] == 2:
            log_to_file(
                3, 'ERROR! No items remaining, this seems hardly possible due to the stock limit.. Payment_tag: ' + relevant_list[1])
        return True
    # log_to_file(4, 'ERROR! Was unable to update payment delivery ' + relevant_list[1])
    return True


def update_payment_state(db_entries_list, deposit_qtrade_id, deposit_tx_id, deposit_sender_tag):
    # db_entries_list:
    # db_payment_cost[0], db_payment_tag, db_product_id, db_qtrade_id, db_tx_id
    # db_product_type, db_amount_left, db_product_delivery[7], db_seller_name = [8], db_timestamp = [9]

    relevant_list = [i for i in db_entries_list if i[1] == deposit_sender_tag]
    if len(relevant_list) <= 0:
        return False
    relevant_list = relevant_list[0]

    sql = "UPDATE payments SET qtrade_id='{}', tx_id='{}', payment_state='3' WHERE payment_tag='{}'".format(
        deposit_qtrade_id, deposit_tx_id, relevant_list[1])
    MYSQL.sql_pointer.execute(sql)
    MYSQL.my_db.commit()

    sql = "INSERT INTO payment_alerts (user_name, alert_active, message_type, arg, alert_state) VALUES (%s, %s, %s, %s, %s)"
    val = (relevant_list[8], '1', '1', relevant_list[1], '3')
    MYSQL.sql_pointer.execute(sql, val)
    MYSQL.my_db.commit()
    return True


def update_invoice_expired(db_seller_name, db_payment_tag):
    sql = "UPDATE payments SET payment_state='6' WHERE payment_tag='{}'".format(
        db_payment_tag)
    MYSQL.sql_pointer.execute(sql)
    MYSQL.my_db.commit()

    sql = "INSERT INTO payment_alerts (user_name, alert_active, message_type, arg, alert_state) VALUES (%s, %s, %s, %s, %s)"
    val = (db_seller_name, '1', '1', db_payment_tag, '2')
    MYSQL.sql_pointer.execute(sql, val)
    MYSQL.my_db.commit()


def log_to_file(error_code, str_to_log):
    with open('x/gateway_log.txt', 'a') as f:
        now = str(datetime.datetime.now())
        to_log = now + ' - CODE: ' + \
            str(error_code) + ' - Info: ' + str_to_log + "\n"
        f.write(to_log)
        print(to_log)


def update_deposits():
    # sql = "SET @@session.time_zone='+00:00'";
    # MYSQL.sql_pointer.execute(sql)
    # MYSQL.my_db.commit()
    # if determine_action_necessary() is True:  #
    db_entries_list = []
    db_entries = mysql_select(
        '*', 'payments', 'payment_state', '1', 'timestamp', '500', 'DESC')[1:]
    # print(db_entries)
    for db_entry in db_entries:
        db_qtrade_id = db_entry['qtrade_id']
        db_payment_tag = db_entry['payment_tag']
        db_tx_id = db_entry['tx_id']
        db_payment_cost = db_entry['payment_cost']
        db_product_id = str(db_entry['product_id'])
        db_seller_name = db_entry['user_name_seller']
        db_timestamp = db_entry['timestamp']

        db_timestamp_secs = int(time.mktime(datetime.datetime.strptime(
            db_timestamp, "%Y-%m-%d %H:%M:%S").timetuple()))
        db_timestamp_secs_upperbound = db_timestamp_secs + 1800
        db_timestamp_secs_now = int(
            datetime.datetime.timestamp(datetime.datetime.now()))
        # ts_together = str(db_timestamp_secs) + ' = ' + str(db_timestamp_secs_upperbound)
        # log_to_file(000, ts_together)

        if db_timestamp_secs_now < db_timestamp_secs_upperbound:
            log_to_file(
                199, 'Payment invoice not yet expired, looking up product for payment_tag ' + db_payment_tag)
            db_product_entries = mysql_select(
                '*', 'products', 'product_id', db_product_id, 'timestamp', '1', 'DESC')[1:]
            for db_product_entry in db_product_entries:  # this is one entry, db_product_id = UNIQUE
                db_product_type = db_product_entry['product_type']
                db_amount_left = db_product_entry['amount_left']
                db_product_delivery = db_product_entry['product_delivery']
                db_entries_list.append([db_payment_cost, db_payment_tag, db_product_id, db_qtrade_id, db_tx_id,
                                        db_product_type, db_amount_left, db_product_delivery, db_seller_name, db_timestamp])
        elif db_timestamp_secs_now > db_timestamp_secs_upperbound:
            log_to_file(
                198, 'Payment invoice expired, changing status to failed and adding alert for payment_tag ' + db_payment_tag)
            update_invoice_expired(db_seller_name, db_payment_tag)

    res = api.get('https://api.qtrade.io/v1/user/deposits').json()
    for i in res['data']['deposits']:
        deposit_qtrade_id = i['id']
        deposit_amount = i['amount']
        deposit_currency = i['currency']
        deposit_tx_id = i['network_data']['txid']
        deposit_status = i['status']
        deposit_sender_tag = i['network_data']['sender_data']
        deposit_confirms = i['network_data']['confirms']
        deposit_confirms_required = i['network_data']['confirms_required']

        print(deposit_qtrade_id, deposit_amount, deposit_currency, deposit_tx_id,
              deposit_status, deposit_sender_tag, deposit_confirms_required, deposit_confirms)
        if determine_deposit_confirmed(deposit_confirms, deposit_confirms_required, deposit_status, deposit_currency) and \
                deposit_sender_tag.isalnum() and deposit_qtrade_id.isalnum() and deposit_tx_id.isalnum() and \
                determine_amount_fulfilled(deposit_sender_tag, deposit_amount, db_entries_list):
            if update_payment_state(db_entries_list, deposit_qtrade_id, deposit_tx_id, deposit_sender_tag):
                if update_payment_delivery(db_entries_list, deposit_sender_tag) is False:
                    log_to_file(
                        1, 'ERROR! Unable to update payment delivery/shrink' + str(db_entries_list))
            else:
                log_to_file(
                    2, 'ERROR! Unable to update payment state' + str(db_entries_list))

        print('Next..')


if __name__ == '__main__':
    def me():
        try:
            update_deposits()
        except json.decoder.JSONDecodeError:
            time.sleep(60)
            me()

    me()
