<?php 

  require_once 'functions.php';

  header("Content-Type: application/octet-stream; charset=UTF-8");
  
  session_start();
 
  if (isset($_SESSION['login'])){
     
    $login = sanitizeString($_SESSION['login']);

    $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetch(PDO::FETCH_BOTH)[0];
    $dir_path = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user_id'")->fetch(PDO::FETCH_BOTH)[0];

    if(isset($_FILES['file']['name'])){
      $date_of_upload = date("F j, Y, g:i a");
      $filename = $_FILES['file']['name'];
      $saveto = "var/www/usr/$dir_path/" . str_replace(' ', '_', $filename);
      //$saveto = str_replace(' ', '_', $saveto);
      move_uploaded_file($_FILES['file']['tmp_name'], $saveto);
      $file_type = filetype($saveto);
      $file_size = filesize($saveto);
      queryMysql("INSERT INTO storage(dirname, filename,  date_of_upload, dir_ID, filesize, type) VALUES('$dir_path','$filename', '$date_of_upload', '$dir_path', '$file_size', '$file_type')");
    }

    die(http_response_code(230));

  }
  else die(http_response_code(237)); 
?>
