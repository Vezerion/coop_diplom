<?php 
  require_once('functions.php');
  
  header("Content-Type: application/json; charset=UTF-8");
  if (isset($_SERVER["REQUEST_METHOD"]) == "POST")
    $data = json_decode(file_get_contents('php://input'), true);
  if (!isset($data['login']) || !isset($data['userpass']))
  {
    http_response_code(235);
    die(json_encode(['error' => 'Неверный запрос']));
  }
  $login = sanitizeString($data['login']);
  $userpass = sanitizeString($data['userpass']);
   
  $result = queryMySQL("SELECT login,userpass FROM user WHERE login='$login'")->fetch(PDO::FETCH_LAZY);  
  
  if(isset($result->login) &&  isset($result->userpass) && $result->login == $login && password_verify($userpass, $result->userpass)){
    session_start();
    $_SESSION['login'] = $login;
    $_SESSION['userpass'] = $pass;
    die(http_response_code(230));
  }
  else {
    die(http_response_code(237));
  }

?>