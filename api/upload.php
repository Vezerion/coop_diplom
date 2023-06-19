<?php 

  require_once 'functions.php';
  //date_default_timezone_set(date_default_timezone_get());
  date_default_timezone_set('Etc/GMT-3');
  header("Content-Type: application/octet-stream; charset=UTF-8");
  $file = file_get_contents('php://input');
  session_start();
 
  if (isset($_SESSION['login'])){
     
    $login = sanitizeString($_SESSION['login']);

    $user = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetchColumn();
    $dir_id = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user'")->fetchColumn();

    if(isset($_FILES['file'])){
      $date_of_upload = date("F j, Y, g:i a");
      $filename = $_FILES['file']['name'];
      $file_type = $_FILES['file']['type'];
      $file_size = $_FILES['file']['size'];
      $file_tmp = $_FILES['file']['tmp_name'];

      $saveto = "/var/www/j-5cloud/api/var/www/usr/$dir_id/" . basename($filename);

      header("Content-Disposition: attachment; filename=$file");
      $sql = queryMysql("SELECT filename FROM storage WHERE filename = '$filename' AND dir_ID = '$dir_id'")->fetch(PDO::FETCH_LAZY);
      
      if ($filename == $sql->filename){
        http_response_code(238);
        die();
      }

      if(is_uploaded_file($file_tmp)){
        move_uploaded_file($file_tmp, $saveto);
        queryMysql("INSERT INTO storage(dirname, filename,  date_of_upload, dir_ID, filesize, type) VALUES('$dir_id','$filename', '$date_of_upload', '$dir_id', '$file_size', '$file_type')");
        http_response_code(230);
        die();
      }
      else{
        die(http_response_code(400));
      }
      
      
    }
    

  }
  else die(http_response_code(237)); 
?>
