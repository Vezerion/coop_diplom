<?php 
  require_once 'functions.php';
  header("Content-Type: application/json; charset=UTF-8");
 
  json_check(json_last_error());
  session_start();
  if (!check_session()){
      http_response_code(240);
      die();
  }
  
  if($_SERVER["REQUEST_METHOD"] == "POST"){
      $data = json_decode(file_get_contents('php://input'), true);
  }
  else{
      http_response_code(239);
      die();
  }

  if(isset($data)){
    $login = $_SESSION['login'];
    $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetchColumn();
    $dir_path = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user_id'")->fetchColumn();

    $filename_post = sanitizeString($data['name']);
    $filename_in_tb = queryMysql("SELECT filename FROM storage WHERE filename = '$filename_post' AND dir_ID = '$dir_path'")->fetchColumn();
    
    if(!strcmp($filename_post, $filename_in_tb)){
      unlink("/var/www/j-5cloud/api/var/www/usr/$dir_path/$filename_in_tb");
      queryMysql("DELETE FROM storage WHERE filename = '$filename_in_tb' AND dir_ID = '$dir_path';");
    }
    http_response_code(230);
    die();
  }
  else {
    http_response_code(240);
    die();
  }


?>