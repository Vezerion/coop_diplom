<?php 
  require_once 'functions.php';
  
  session_start();
  
  header("Content-Type: application/json; charset=UTF-8");
  
  if ($_SERVER["REQUEST_METHOD"] == "POST")
    $data = json_decode(file_get_contents('php://input'), true);
  else {
    http_response_code(239);
    die();
  }
  if (isset($_SESSION['login']))
  {
    destroySession();
    http_response_code(230);
    die();
  }
  else{
    http_response_code(240);
    die();
  } 
?>