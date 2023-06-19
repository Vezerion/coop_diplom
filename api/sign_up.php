<?php   
    require_once('functions.php');

    header("Content-Type: application/json; charset=UTF-8");
    $_POST = json_decode(file_get_contents('php://input'), true);
   
    json_check(json_last_error());

    if (isset($_SESSION['login'])){
      destroySession();
      die(http_response_code(240));
    }
    
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['email']) && isset($_POST['login']) && isset($_POST['userpass'])){
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
      
      if ($login == "" || $pass == "" || $username == ""){
        http_response_code(231);
        die();
      }
      elseif ((queryMysql("SELECT login FROM user WHERE login='$login'")->fetchAll(PDO::FETCH_BOTH))) {
        http_response_code(233);
        die();
      }elseif ((queryMysql("SELECT email FROM user WHERE email='$email'")->fetchAll(PDO::FETCH_BOTH))) {
        http_response_code(234);
        die();
      }
      else
      {
        $result = queryMysql("SELECT * FROM user WHERE login='$login'");
  
        if ($result->rowCount() || !email_valid($email) || !checkPass($pass) || 
            !((preg_match("/[a-z]/", $name) || preg_match("/[A-Z]/", $name)) && !preg_match("/[0-9]/", $name) || preg_match("//", $name)) ||
            !((preg_match("/[a-z]/", $surname) || preg_match("/[A-Z]/", $surname)) && !preg_match("/[0-9]/", $surname) || preg_match("//", $surname)) 
        ){
          http_response_code(232);
          die();
        }
        else{
          if ($date_of_birth == "")
            $date_of_birth =  '1900-01-01';
          
          $user_id = GenUserID(); 
          $date_of_create = date("F j, Y, g:i a"); 
          $dir_id  = hash('md5',$user_id);
          $pass  = password_hash($pass,  PASSWORD_ARGON2I);
          
          mkdir("/var/www/j-5cloud/api/var/www/usr/$dir_id", 0777, true);
          
          
          queryMysql("INSERT INTO user VALUES('$user_id', '$login', '$pass', '$email')");
          queryMysql("INSERT INTO profile VALUES('$username', '$name','$surname','$date_of_birth','$country','$city','$phone','$date_of_create', '$user_id')");
          queryMysql("INSERT INTO dir VALUES('$dir_id','$date_of_create')");
          queryMysql("INSERT INTO user_has_files VALUES('$user_id','$dir_id')");
    
          session_start();
          $_SESSION['login'] = $login;
          $_SESSION['userpass'] = $pass;
          
          http_response_code(230);
        }
      }
    }
    else {
      http_response_code(235);
      die();
    }

?>