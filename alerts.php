

<?php
    // XXX: Requirements
    require_once("config/db.php");
    require_once("classes/Login.php");
    require_once("messages.php");
    $login = new Login();
    error_reporting( error_reporting() & ~E_NOTICE );
    // XXX: Requirements


    function getValue($processing_type, $values_needed, $fields_list, $table, $filter_key, $filter_value, $sorted_by, $sorted_m, $limit, $msg_type_command) {
      $return_array = array();
      $path = "-";
      if($processing_type === 'select'){
        $path = $path . "MYSQL_SELECT_GATE.py";
        // XXX: Executing
        $command = escapeshellcmd($path . " --fields_list " . $fields_list . " --table " . $table . " --filter_key " . $filter_key . " --filter_value " . $filter_value . " --sorted_by " . $sorted_by . " --sorted_m " . $sorted_m . " --limit " . $limit);
        $output = shell_exec($command);
        $output_array = json_decode($output, true);

        // echo $output;
        // XXX: Executing
        if (strlen($output)>1){
          foreach($output_array as $key => $value){
            $temp_array = array();
            foreach($values_needed as $head => $tail){
              // XXX: Output data
              $value_to_return = $value[$tail];
              if($value_to_return != NULL){
              array_push($temp_array, $value_to_return); }
                if (strlen($value['total'])>0){
                    $total = (int)$value['total'];
                    if($total > 0) {
                    } else {
                      return 'NULL';
                    }
                  }
            }
            if(count($temp_array)>0) {
            array_push($return_array, $temp_array);
          }
              }

              $val = $return_array;
              // var_dump($val);
              if($val != 'NULL'){
                $entire_array = array();
              foreach($val as $key => $value){
                $temp_array = array();
                foreach($values_needed as $head => $tail){
                  // echo $head;
                  // echo $tail;
                  // NOTE: assign
                  if($tail === 'message_type'){
                    if($msg_type_command === 'none'){
                      $go_array[$tail] = $val[$key][$head];
                    } else {
                      $go_array[$tail] = $msg_type_command;
                    }
                  } else { $go_array[$tail] = $val[$key][$head]; }
                  // $go_array[$tail] = $val[$key][$head];
                  // var_dump($go_array[$tail]);
                }
                // NOTE: push
                array_push($temp_array, $go_array);
                array_push($entire_array, $go_array);
                // showMessage($temp_array);
              } } else { echo 't';}
              showMessage($entire_array);


              // return $return_array;

              // foreach($return_array as $key => $value){
              //   $temp_array = array();
              //   foreach($values_needed as $head => $tail){
              //     $go_array = $val[$key][$head];
              //     array_push($temp_array, $go_array);
              //   }
              //   return($temp_array); //
              // }
            } else {
        return 'NULL';
      }
      } elseif($processing_type === 'delete'){
        $path = $path . "MYSQL_DELETE_ROW_table_key_value.py ";
      } elseif($processing_type === 'insert'){
        $path = $path . "MYSQL_INSERT_table_fields_values.py ";
      }
    }

  //   $path = "--";
  //
  //   // XXX: Pick one
  //   $select = "MYSQL_SELECT_table_fields_filter_sort_limit.py ";
  //   $delete = "MYSQL_DELETE_ROW_table_key_value.py ";
  //   $insert = "MYSQL_INSERT_table_fields_values.py ";
  //   // XXX: Pick one
  //
  //   // XXX: Fill in
  //   $fields_list = "ALL";
  //   $table = "order_alerts";
  //   $filter_key = "user_name";
  //   $filter_value = $_SESSION['user_name'];
  //   $sorted_by = "timestamp";
  //   $sorted_m = "DESC";
  //   $limit = "5";
  //   // XXX: Fill in
  //
  //   // XXX: Executing
  //   $command = escapeshellcmd($path . $select . "--fields_list " . $fields_list . " --table " . $table . " --filter_key " . $filter_key . " --filter_value " . $filter_value . " --sorted_by " . $sorted_by . " --sorted_m " . $sorted_m . " --limit " . $limit);
  //   $output = shell_exec($command);
  //   $output_array = json_decode($output, true);
  //   // XXX: Executing
  //   if (strlen($output)>1){
  //     foreach($output_array as $key => $value){
  //       // XXX: Output data
  //       $msg_type = (int)$value['alert_message'];
  //       $timestamp = $value['timestamp'];
  //       $arg = $value['arg'];
  //       showMessage($msg_type, $timestamp, $arg);
  //       // $alert_id = (int)$value['alert_id'];
  //       echo $alert_id;
  //         if (strlen($value['total'])>0){
  //             $total = (int)$value['total'];
  //             if($total > 0) {
  //             } else {
  //               echo 'No results';
  //             }
  //           }
  //         }
  //       } else {
  //   echo 'Empty response';
  // }


    //
    // $command = escapeshellcmd($path . $delete . "--table order_alerts --filter_key alert_id --filter_value ALL");
    // $output = shell_exec($command);
    // echo $output;

    // $command = escapeshellcmd($path . $insert . "--table order_alerts --row user_id, alert_active, altert_message --value 1, 1, 1");
    // $output = shell_exec($command);
    // echo $output;
    ?>
