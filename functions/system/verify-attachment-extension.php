<?php
require($_SERVER['DOCUMENT_ROOT'].'/includes/config.php');

$file_names = $_POST['file_names'];

$not_valid = 0;

foreach($file_names as $key => $file_name) {
  if(checkAttachmentExt($file_name)) {
    
  } else {
    $not_valid++;
  }
}

if($not_valid != 0) {
  echo 'not valid';
} else {
  echo 'valid';
}
?>