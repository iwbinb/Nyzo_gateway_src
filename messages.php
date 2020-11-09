<?php
require 'user_reputation.php';
function argArrayHandler($array_arg, $type)
{
    //<div class="card mx-left mt-2" style="width: auto;"><div class="card-header bg-primary text-white">Table example</div>
    //<div class="card">
    $ctable_open_head = '<div class="table-responsive"><table class="table table-bordered" id="dataTable" width="100%" cellspacing="0"><thead><tr>';
    $ctable_close_head = '</tr></thead>';
    $ctable_open_body = '<tbody>';
    $ctable_open_tr = '<tr>';
    $ctable_close_tr = '</tr>';
    $ctable_open_td = '<td>';
    $ctable_close_td = '</td>';
    $ctable_close_body_table = '</tbody></table></div>';
    //</div>
    //</div>
    if ($type === 'header') {
        echo $ctable_open_head;

        foreach ($array_arg as $key => $value) {
            if ($key === 'message_type') {
                continue;
            }
            if ($key === 'timestamp') {
                $key = 'Date';
            }
            if ($key === 'payment_tag') {
                $key = 'Payment Tag';
            }
            if ($key === 'product_id') {
                $key = 'Product ID';
            }
            if ($key === 'payment_id') {
                $key = 'Payment ID';
            }
            if ($key === 'payment_type') {
                $key = 'Type';
            }
            if ($key === 'payment_extra') {
                $key = 'Product ID';
            }
            if ($key === 'tx_id') {
                $key = 'Transaction ID';
            }
            if ($key === 'payment_cost') {
                $key = 'Amount';
            }
            if ($key === 'payment_state') {
                $key = 'Payment state';
            }
            if ($key === 'download_type') {
                $key = 'Download type';
            }
            if ($key === 'download_hash') {
                $key = 'Access token';
            }
            if ($key === 'file_name') {
                $key = 'Filename';
            }
            if ($key === 'data_type') {
                $key = 'Datatype';
            }
            if ($key === 'user_name') {
                $key = 'Username';
            }
            if ($key === 'user_positive_fb') {
                $key = 'Positive feedback';
                $value = strval($value);
            }
            if ($key === 'user_negative_fb') {
                $key = 'Negative feedback';
                $value = strval($value);
            }
            if ($key === 'user_id') {
                $key = 'User ID';
            }
            if ($key === 'downloads_left') {
                $key = 'Downloads left';
            }
            if ($key === 'dl_end_date') {
                $key = 'Expiry date';
            }
            echo '<th>' . $key . '</th>';

            if ($key === 'Expiry date') {
                echo '<th></th>';
            }
        }
        echo $ctable_close_head;
        echo $ctable_open_body;
    } elseif ($type === 'row') {
        echo $ctable_open_tr;
        foreach ($array_arg as $key => $value) {
            if ($key === 'user_positive_fb') {
                $value = strval($value);
            }
            if ($key === 'user_negative_fb') {
                $key = 'Negative feedback';
                $value = strval($value);
            }

            if ($key === 'message_type') {
                continue;
            }

            if ($key === 'file_name') {
                $row_file_name = $value;
            }

            if ($key === 'download_hash') {
                $row_access_token = $value;
            }

            if ($key === 'data_type') {
                $row_data_type = $value;
            }

            if ($key === 'payment_state' && $value === 1) {
                $value = 'Pending payment';
            }
            if ($key === 'payment_state' && $value === 2) {
                $value = 'Confirming';
            }
            if ($key === 'payment_state' && $value === 3) {
                $value = 'Confirmed';
            }
            if ($key === 'payment_state' && $value === 4) {
                $value = 'Waiting for buyer';
            }
            if ($key === 'payment_state' && $value === 5) {
                $value = 'Confirmed and sold';
            }
            if ($key === 'payment_state' && $value === 6) {
                $value = 'Expired';
            }
            if ($key === 'download_type' && $value === 1) {
                $value = 'Full';
            }
            if ($key === 'download_type' && $value === 0) {
                $value = 'Partial';
            }
            echo $ctable_open_td;
            echo $value;
            echo $ctable_close_td;

            if ($key === 'dl_end_date') {
                echo '<td><a href="downloads.php?filename=';
                echo $row_file_name;
                echo '&access_token=';
                echo $row_access_token;
                echo '">Download file</a></td>';
            }
        }
        echo $ctable_close_tr;
    } elseif ($type === 'footer') {
        echo $ctable_close_body_table;
    }
}

function argArrayHandlerMarketplace($array_arg)
{
    $piece_head = '<div class="col-sm-4 ml-0 mr-0 px-1" style=""><div class="card mt-3" style="border: 1px solid #dee2e6;"><div class="card-body mx-2 mt-2 mb-2" style="">';
    $piece_before_name = '<h5 class="card-title">';
    $piece_product_name = 'INVALID';
    $piece_after_name = '</h5>';
    $piece_before_description = '<p class="card-text">';
    $piece_product_description = 'INVALID';
    $piece_after_description = '</p></div><ul class="list-group list-group-flush">';
    $piece_before_type = '<li class="list-group-item"><b>Type: </b>';
    $piece_product_type = 'INVALID';
    $piece_after_type = '</li>';
    $piece_before_amt_left = '<li class="list-group-item"><b>Amount left: </b>';
    $piece_product_amt_left = '0';
    $piece_after_amt_left = '</li>';
    $piece_before_price = '<li class="list-group-item"><b>Price: </b>';
    $piece_product_price = 'INVALID';
    $piece_after_price = ' ∩</li>';
    $piece_before_seller = '<li class="list-group-item"><b>Seller: </b><a href="user?name=';
    $piece_product_seller = 'INVALID';
    $piece_after_seller = '">';
    $piece_before_button = '</a></li>';
    $piece_after_rep = '<li class="list-group-item mx-2" id="purchaseButton"><a class="btn btn-success" style="" href="purchase?id=';
    $piece_product_id = '0';
    $piece_after_button = '">Get</a></li></ul></div></div>';

    foreach ($array_arg as $key => $value) {
        if ($key === 'message_type') {
            continue;
        }
        if ($key === 'timestamp') {
            $piece_timestamp = $value;
        }
        if ($key === 'product_id') {
            $piece_product_id = $value;
        }
        if ($key === 'product_type') {
            $piece_product_type = $value;
            if ($piece_product_type === 1) {
                $piece_product_type = 'URL';
            } elseif ($piece_product_type === 2) {
                $piece_product_type = 'Serial';
            } else {
                $piece_product_type = 'INVALID';
            }
        }
        if ($key === 'product_price') {
            $piece_product_price = $value;
        }
        if ($key === 'product_name') {
            $piece_product_name = $value;
        }
        if ($key === 'product_description') {
            $piece_product_description = $value;
        }
        if ($key === 'user_name') {
            $piece_product_seller = $value;
        }
        if ($key === 'amount_left') {
            $piece_product_amt_left = $value;
            $vis_piece_product_amt_left = $value;
            if ($piece_product_amt_left === 500) {
                $vis_piece_product_amt_left = '∞';
            }
        }
        if ($key === 'download_hash') {
            $key = 'Access token';
        }
        if ($key === 'file_name') {
            $key = 'Filename';
        }
        if ($key === 'data_type') {
            $key = 'Datatype';
        }
        if ($key === 'downloads_left') {
            $key = 'Downloads left';
        }
        if ($key === 'dl_end_date') {
            $key = 'Expiry date';
        }
        // if (empty($value){
      //   $value = 'Placeholder';
      // }
    }

    if ($piece_product_amt_left <= 5) {
        $piece_after_rep = '<li class="list-group-item mx-2" id="purchaseButton"><a class="btn btn-secondary" style="" href="purchase?id=';
        $piece_product_id = '0';
        $piece_after_button = '">Out of stock</a></li></ul></div></div>';
    }
    if (strlen($piece_product_seller) > 1) {
        if ($piece_product_seller === $_SESSION['user_name']) {
            $piece_after_rep = '<li class="list-group-item mx-2" id="purchaseButton"><a class="btn btn-primary" style="" href="editproduct?id=';
            $piece_after_button = '">Edit product</a></li></ul></div></div>';
        }
    }

    echo $piece_head;
    echo $piece_before_name;
    echo $piece_product_name;
    echo $piece_after_name;
    echo $piece_before_description;
    echo $piece_product_description;
    echo $piece_after_description;
    echo $piece_before_type;
    echo $piece_product_type;
    echo $piece_after_type;
    echo $piece_before_amt_left;
    echo $vis_piece_product_amt_left;
    echo $piece_after_amt_left;
    echo $piece_before_price;
    echo $piece_product_price;
    echo $piece_after_price;
    echo $piece_before_seller;
    echo $piece_product_seller;
    echo $piece_after_seller;
    echo $piece_product_seller;
    echo $piece_before_button;
    echo '<li class="list-group-item small mx-1">Seller reputation';
    getReputationBar($piece_product_seller);
    echo '</li>';
    echo $piece_after_rep;
    echo $piece_product_id;
    echo $piece_after_button;
}

function showMessage($ta)
{
    $allow_header = 1;
    if ($ta != 'NULL') {
        foreach ($ta as $temp_array) {
            $messagetype = $temp_array['message_type'];

            if ($messagetype === 1) {
                $timestamp = $temp_array['timestamp'];
                $arg = $temp_array['arg'];
                $alert_state = $temp_array['alert_state'];
                // $alert_state = 1
                // NOTE: definitions - after assigning arguments
                $array_expected = "Expected an array but didn't receive one. Message type: " . $messagetype;
                $non_array_expected = "Expected a value but got an array: " . $messagetype;
                $alert3 = '<div class="alert alert-success mx-0 mt-0 mb-0" role="alert" style="border-radius: 0rem;"><i>' . $timestamp . ':</i><br> Payment <b>successful</b> : <a href="process?tag=' . $arg . '">' . $arg . '</a></div>';
                $alert2 = '<div class="alert alert-danger mx-0 mt-0 mb-0" role="alert" style="border-radius: 0rem;"><i>' . $timestamp . ':</i><br> Payment <b>failed</b> : <a href="process?tag=' . $arg . '">' . $arg . '</a></div>';
                $alert1 = '<div class="alert alert-primary mx-0 mt-0 mb-0" role="alert" style="border-radius: 0rem;"><i>' . $timestamp . ':</i><br> Payment <b>pending</b> : <a href="process?tag=' . $arg . '">' . $arg . '</a></div>';
                $alert4 = '<div class="alert alert-primary mx-0 mt-0 mb-0" role="alert" style="border-radius: 0rem;"><i>' . $timestamp . ':</i><br> Your payment <a href="process?tag=' . $arg . '">' . $arg . '</a> has been added to the orderbook. </div>';
                $alert5 = '<div class="alert alert-primary mx-0 mt-0 mb-0" role="alert" style="border-radius: 0rem;"><i>' . $timestamp . ':</i><br> Your payment <a href="process?tag=' . $arg . '">' . $arg . '</a> has been settled for BTC. <br>Effective rate: 123 sats </div>';
                $alert6 = '<div class="alert alert-danger mx-0 mt-0 mb-0" role="alert" style="border-radius: 0rem;"><i>' . $timestamp . ':</i><br> Processing <b>ERROR</b> : <a href="process?tag=' . $arg . '">' . $arg . '</a> Please open a <a href="support.php">support ticket</a>. </div>';
                $alert7 = '<div class="alert alert-success mx-0 mt-0 mb-0" role="alert" style="border-radius: 0rem;"><i>' . $timestamp . ':</i><br> Processing <b>completed</b> : <a href="process?tag=' . $arg . '">' . $arg . '</a> </div>';
                if (is_array($arg)) {
                    echo $non_array_expected;
                } else {
                    if ($alert_state === 1) {
                        echo $alert1;
                    }
                    if ($alert_state === 2) {
                        echo $alert2;
                    }
                    if ($alert_state === 3) {
                        echo $alert3;
                    }
                    if ($alert_state === 4) {
                        echo $alert4;
                    }
                    if ($alert_state === 5) {
                        echo $alert5;
                    }
                    if ($alert_state === 6) {
                        echo $alert6;
                    }
                    if ($alert_state === 7) {
                        echo $alert7;
                    }
                }
            } elseif ($messagetype === 2) {
                if ($allow_header === 1) {
                    argArrayHandler($temp_array, 'header');
                    $allow_header = 0;
                }
                argArrayHandler($temp_array, 'row');
            } elseif ($messagetype === 3) {
                argArrayHandlerMarketplace($temp_array);
            } else {
                echo 'There was a problem processing message_type: ' . $messagetype;
            }
        }
        if ($messagetype === 2) {
            argArrayHandler($temp_array, 'footer');
        }
    }
}
