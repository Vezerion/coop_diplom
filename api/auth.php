<?php 
  require_once('functions.php');
  session_start();
  header("Content-Type: application/json; charset=UTF-8");
  $_POST = json_decode(file_get_contents('php://input'), true);
  if (isset($_POST))
  {
    $login = sanitizeString($_POST['login']);
    $pass = sanitizeString($_POST['userpass']);
    $pass = hash('md5', $pass);

    if ($login == "" || $pass == "")
      die(http_response_code(231));
    else
    {
      $result = queryMySQL("SELECT login,userpass FROM user
        WHERE login='$login' AND userpass='$pass'");
     
      if ($result->rowCount() == 0)
      {
        die(http_response_code(237));
      }
      else
      {
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