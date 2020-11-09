<?php

require_once("json_validate.php");

function timeLeftProgressbar($percentage_tx_delay, $mins_tx_delay_float, $percentage_tx_confirm, $mins_after_delay, $max_tx_time)
{
    $json = file_get_contents('https://nyzo.co/cycleInfo');
    $obj = json_validate($json);
    $delay_secs = $obj->transactionDelaySeconds;
    $relevant_edge = $obj->frozenEdgeHeight;
    if (is_int($delay_secs) === false) {
        exit("Failed to get data from endpoint. <br>Error type: 2 <br>Please contact the system administrator.<br>");
    }
    if (is_int($relevant_edge) === false || $relevant_edge < 2480000) {
        exit("Failed to get data from endpoint. <br>Error type: 3 <br>Please contact the system administrator.<br>");
    }
    $mins_tx_delay = ($delay_secs)/60;
    $mins_tx_delay_float = round($mins_tx_delay, 2);
    if ($mins_tx_delay_float < 5) {
        $mins_tx_delay_float = 5;
    }
    $mins_tx_delay_echo = "Network TX delay: " . $mins_tx_delay_float . " min";

    if ($mins_tx_delay > 15) {
        echo $mins_tx_delay_echo;
        exit("<br>Transactions are currently delayed more than 15 minutes.<br>Purchasing products has been temporarily disabled.<br>More information about the chain can be found on nyzo.co");
    }

    if ($mins_tx_delay_float <= 1) {
        $mins_tx_delay_float = 1;
        $percentage_tx_delay = 0;
        $percentage_tx_confirm = 100;
    } else {
        $percentage_tx_delay = 100/($max_tx_time/$mins_tx_delay_float);
        $percentage_tx_confirm = 100-(($mins_tx_delay_float/$max_tx_time)*100);
        // echo $percentage_tx_delay;
        // echo $percentage_tx_confirm;
        $percentage_tx_delay = round($percentage_tx_delay, 2);
        $percentage_tx_confirm = round($percentage_tx_confirm, 2);
    }

    $mins_after_delay = $max_tx_time - $mins_tx_delay_float;
    $mins_after_delay = round($mins_after_delay, 2);

    if ($percentage_tx_delay < 25) {
        $percentage_tx_delay = 25;
    }

    echo '<div class="progress">
  <div class="progress-bar bg-secondary" style="width:';
    echo $percentage_tx_delay;
    echo '%">
    TX delay: ';
    echo $mins_tx_delay_float;
    echo ' min
  </div>
  <div class="progress-bar bg-success" style="width:';
    echo $percentage_tx_confirm;
    echo '%">Confirmation time left: ';
    echo $mins_after_delay;
    echo ' min</div>
</div>';


    // echo '<div class="progress">
//   <div class="progress-bar bg-success" style="width:100%">
//     30 min
//   </div>
// </div>';
}
