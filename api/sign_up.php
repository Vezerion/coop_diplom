<?php   
    require_once('functions.php');

    header("Content-Type: application/json; charset=UTF-8");
    $_POST = json_decode(file_get_contents('php://input'), true);
   
    switch(json_last_error()){
      case JSON_ERROR_NONE:
        break;
      case JSON_ERROR_DEPTH:
        die("236 JSON_ERROR_DEPTH");
      case JSON_ERROR_STATE_MISMATCH:
        die("236 JSON_ERROR_STATE_MISMATCH");
      case JSON_ERROR_CTRL_CHAR:
        die("236 JSON_ERROR_CTRL_CHAR");
      case JSON_ERROR_SYNTAX:
        die("236 JSON_ERROR_SYNTAX");
      case JSON_ERROR_UTF8:
        die("236 JSON_ERROR_UTF8");
      case JSON_ERROR_RECURSION:
        die("236 JSON_ERROR_RECURSION");    
      case JSON_ERROR_INF_OR_NAN:
        die("236 JSON_ERROR_INF_OR_NAN");  
      case JSON_ERROR_UNSUPPORTED_TYPE:
        die("236 JSON_ERROR_UNSUPPORTED_TYPE");
      case JSON_ERROR_INVALID_PROPERTY_NAME:
        die("236 JSON_ERROR_INVALID_PROPERTY_NAME"); 
      case JSON_ERROR_UTF16:
        die("236 JSON_ERROR_UTF16");    
      default:
        die("236 UNDEFINED_ERROR");
    }


    if (isset($_SESSION['login'])){
      destroySession();
      die("240");
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
        die(json_encode("231"));
      else
      {
        $result = queryMysql("SELECT * FROM user WHERE login='$login'");
  
        if ($result->rowCount())
          die(json_encode("232"));
        elseif (!email_valid($email)){
          die(json_encode("233"));
        }
        elseif(!checkPass($pass)){
          die(json_encode("234"));
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
          
          die(json_encode("230"));
        }
      }
    }
    else {
      die(json_encode('235'));
    }

?>