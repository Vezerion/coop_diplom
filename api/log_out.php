<?php #log out\
  require_once 'functions.php';
  session_start();
  header("Content-Type: application/json; charset=UTF-8");
  $_POST = json_decode(file_get_contents('php://input'), true);
  $login = sanitizeString($_POST['login']);
  $username = sanitizeString($_POST['username']);
  $email = sanitizeString($_POST['email']);
  if (isset($_SESSION[$login]))
  {
    destroySession();
    die(http_response_code(230));;
  }
  else die(http_response_code(240));
?>