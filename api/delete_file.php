<?php 
  require_once 'functions.php';
  header("Content-Type: application/json; charset=UTF-8");
  session_start();
  if (isset($_SESSION['login'])){
    $file = json_decode($_POST['filename'], true);
    $login = $_SESSION['login'];
    $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetch(PDO::FETCH_BOTH);
    $user_id = $user_id[0];
    $file_path = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user_id'")->fetch(PDO::FETCH_BOTH);
    $file = $_POST['filename'];
    $path = "var/www/usr/$file_path[0]/";
    unlink($path . $file);
    queryMysql("DELETE  FROM storage WHERE filename = '$file' AND dir_ID = '$file_path[0]';");
    die(json_encode("230"));
  }
  else die(json_encode("237"));

?>