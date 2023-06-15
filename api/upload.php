<?php 
  require_once 'functions.php';
  header("Content-Type: application/json; charset=UTF-8");
  session_start();
  
  if (isset($_SESSION['login'])){
  
    $login = $_SESSION['login'];
    $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetch(PDO::FETCH_BOTH);
    $user_id = $user_id[0];
    $file_path = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user_id'")->fetch(PDO::FETCH_BOTH);

    if(isset($_FILES['file_id'])){

      $date_of_upload = date("F j, Y, g:i a");
      $filename = $_FILES['file_id'];
      $saveto = "var/www/usr/$file_path[0]/$filename[name]";
      $saveto = str_replace(' ', '_', $saveto);
      move_uploaded_file($_FILES['file_id']['tmp_name'], $saveto);
      $file_type = filetype($saveto);
      $file_size = filesize($saveto);
      queryMysql("INSERT INTO storage VALUES('$file_path[0]','$filename[name]', '$file_size', '$file_type', ' $date_of_upload', '$file_path[0]')");
    }

    die(json_encode("230"));

  }
  else die(json_encode("237")); 
?>
