import classes.GATE_MYSQL_CONFIG as MYSQL
import datetime
def myconverter(o):
    if isinstance(o, datetime.datetime):
        return o.__str__()

# ---------------------------------------------------------------------------------------------------
from argparse import ArgumentParser

parser = ArgumentParser()
parser.add_argument("-f", "--fields_list", dest="fields_list",
                    help="fields_list for select", metavar="fields_list", required=True, type=str)
parser.add_argument("-t", "--table", dest="table",
                    help="table name for select", metavar="table", required=True, type=str)
parser.add_argument("-fk", "--filter_key", dest="filter_key",
                    help="filter key for select", metavar="filter_key", required=True, type=str)
parser.add_argument("-fv", "--filter_value", dest="filter_value",
                    help="filter value for select", metavar="filter_value", required=True, type=str)
parser.add_argument("-s", "--sorted_by", dest="sorted_by",
                    help="sorted_by for select", metavar="sorted_by", required=True, type=str)
parser.add_argument("-l", "--limit", dest="limit",
                    help="limit for select", metavar="limit", required=True, type=str)
parser.add_argument("-sm", "--sorted_m", dest="sorted_m",
                    help="sorted_m for select", metavar="sorted_m", required=True, type=str)


args = parser.parse_args()
fields_list = args.fields_list
table = args.table
filter_key = args.filter_key
filter_value = args.filter_value
sorted_by = args.sorted_by
limit = args.limit
sorted_m = args.sorted_m

if fields_list == 'ALL':
    fields_list = '*'
# ---------------------------------------------------------------------------------------------------
import json
import re
from bson import json_util


def mysql_select(fields, table, filter_key, filter_value, sorted_by, limit, sorted_m):
    parsed_fields = fields

    executable_sql = "SELECT {} FROM {}".format(parsed_fields, table)
    if filter_key != 'none' and filter_value != 'none':
        executable_sql = executable_sql + " WHERE {} = '{}'".format(filter_key, filter_value)
    if sorted_by != 'none':
        executable_sql = executable_sql + " ORDER BY {} {}".format(sorted_by, sorted_m)
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
    dicts_list.append({'total': len(select_results), 'amt_keys': len(dict_key_results),'keys': str(dict_key_results)})
    for x in select_results:
        pos = select_results.index(x) + 1
        x = list(x)
        dict_test = {}
        for i in range(0, len(x)):
            key_value = dict_key_results[i]
            dict_test.update({key_value:x[i]})
        dicts_list.append(dict_test)
        results_list.append(x)
    results_json = json.dumps(dicts_list, default=myconverter)
    # print(dicts_list)

    if MYSQL.sql_pointer.rowcount > 0:
        print(results_json)
    else:
        print('[{"total": 0}]')


mysql_select(fields_list, table, filter_key, filter_value, sorted_by, limit, sorted_m)
