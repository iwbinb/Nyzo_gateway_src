







<?php
function getReputationBar($user_name)
{
    if (ctype_alnum($user_name)) {
        $user_clean = $user_name;
    } else {
        $user_clean = 'User';
    }
    require_once("config/db.php");
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if ($conn->connect_error) {
        die("Error 877cd ");
    }

    $sql = 'SELECT * from users  WHERE user_name="' . $user_clean . '"';
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $positive_feedback_amt = $row["user_positive_fb"];
            $negative_feedback_amt = $row["user_negative_fb"];
        }
    } else {
        $positive_feedback_amt = 0;
        $negative_feedback_amt = 0;
        $user_clean = 'User';
    }
    $conn->close();

    $negative_feedback_amt = intval($negative_feedback_amt);
    $positive_feedback_amt = intval($positive_feedback_amt);
    $total_feedback = $negative_feedback_amt + $positive_feedback_amt;
    if ($total_feedback === 0) {
        $percentage_negative = 50;
        $percentage_positive = 50;
    }
    // elseif ($negative_feedback_amt === 0 && $positive_feedback_amt > 0) {
    //     $percentage_negative = 10;
    //     $percentage_positive = 90;
    // }
    // elseif ($negative_feedback_amt > 0 && $positive_feedback_amt > 0){
    //
    // }
    // elseif ($positive_feedback_amt === 0 && $negative_feedback_amt > 0) {
    //   $percentage_negative = 90;
    //   $percentage_positive = 10;
    // }
    else {
        $pct_min_each_side = 10;
        $percentage_negative = ($negative_feedback_amt / $total_feedback) * 100;
        $percentage_positive = ($positive_feedback_amt / $total_feedback) * 100;
        if ($percentage_negative < $pct_min_each_side) {
            $diff_to_min = $pct_min_each_side - $percentage_negative;
            $percentage_negative = $percentage_negative + $diff_to_min;
            $percentage_positive = $percentage_positive - $diff_to_min;
        } elseif ($percentage_positive < $pct_min_each_side) {
            $diff_to_min = $pct_min_each_side - $percentage_positive;
            $percentage_negative = $percentage_negative - $diff_to_min;
            $percentage_positive = $percentage_positive + $diff_to_min;
        }
    }
    echo '<div class="progress">
  <div class="progress-bar bg-warning" style="width:';
    echo $percentage_negative;
    echo '%">';
    echo $negative_feedback_amt;
    echo '
  </div>
  <div class="progress-bar bg-success" style="width:';
    echo $percentage_positive;
    echo '%">';
    echo $positive_feedback_amt;
    echo '</div>
</div>';


    // echo '<div class="progress">
//   <div class="progress-bar bg-success" style="width:100%">
//     30 min
//   </div>
// </div>';
}




 ?>
