<?php   
    require_once('functions.php');

    header("Content-Type: application/json; charset=UTF-8");
    $_POST = json_decode(file_get_contents('php://input'), true);
   
    json_check(json_last_error());

    if (isset($_SESSION['login'])){
      destroySession();
      die(http_response_code(240));
    }
    
    if (isset($_POST)){
      $username = sanitizeString($_POST['username']);
      $pass = sanitizeString($_POST['userpass']);
      $login = sanitizeString($_POST['login']);
      $email = sanitizeString($_POST['email']);
      $name = sanitizeString($_POST['name']);
      $surname = sanitizeString($_POST['surname']);
      $date_of_birth = sanitizeString($_POST['date_of_birth']);
      $country = sanitizeString($_POST['country']);
      $city = sanitizeString($_POST['city']);
      $phone = sanitizeString($_POST['phone']);
      
  
      if ($login == "" || $pass == "" || $username == "")
        die(http_response_code(231));
      else
      {
        $result = queryMysql("SELECT * FROM user WHERE login='$login'");
  
        if ($result->rowCount() || !email_valid($email) || !checkPass($pass)){
          die(http_response_code(232));
        }
        else{
        if ($date_of_birth == ""){
          $date_of_birth =  '1900-01-01';
        }
          $user_id = GenUserID(); 
          $date_of_create = date("F j, Y, g:i a"); 
          $dir_id  = hash('md5',$user_id);
          $pass  = hash('md5',$pass);
          
          mkdir("var/www/usr/$dir_id", 0777, true);
          
          
          queryMysql("INSERT INTO user VALUES('$user_id', '$login', '$pass', '$email')");
          queryMysql("INSERT INTO profile VALUES('$username', '$name','$surname','$date_of_birth','$country','$city','$phone','$date_of_create', '$user_id')");
          queryMysql("INSERT INTO dir VALUES('$dir_id','$date_of_create')");
          queryMysql("INSERT INTO user_has_files VALUES('$user_id','$dir_id')");
          
          session_start();
          $_SESSION['login'] = $login;
          $_SESSION['userpass'] = $pass;
          
          die(http_response_code(230));
        }
      }
    }
    else {
      die(http_response_code(235));
    }

?>