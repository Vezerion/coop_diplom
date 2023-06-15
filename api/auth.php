<?php 
  require_once('functions.php');
  session_start();
  header("Content-Type: application/json; charset=UTF-8");

  if (isset($_POST))
  {
    $_POST = json_decode(file_get_contents('php://input'), true);
    $login = sanitizeString($_POST['login']);
    $pass = sanitizeString($_POST['userpass']);
    $pass = hash('md5', $pass);

    if ($login == "" || $pass == "")
      die(json_encode("231"));
    else
    {
      $result = queryMySQL("SELECT login,userpass FROM user
        WHERE login='$login' AND userpass='$pass' ");

      if ($result->rowCount() == 0)
      {
        die(json_encode("232"));
      }
      else
      {
        $_SESSION['login'] = $login;
        $_SESSION['userpass'] = $pass;
        
        die(json_encode("230"));
      }
    }
  }
  else {
    die(json_encode("235"));
  }
?>