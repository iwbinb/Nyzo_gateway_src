<?php

function input_sanitizer($data, $type){
  if($type == 'text'){
    $data = preg_match('/^[a-z\d]{2,64}$/i', $data);
    return $data;
  }
  elseif($type == 'link_product'){
    $data = filter_var($data, FILTER_VALIDATE_URL);
    return $data;
  }
  elseif($type == 'email'){
    $data = filter_var($data, FILTER_VALIDATE_EMAIL);
    return $data;
  }
  else {
    return 'NULL';
  }
}

?>
