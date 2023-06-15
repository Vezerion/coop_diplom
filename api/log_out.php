<?php #log out\
  require_once 'functions.php';
  session_start();
  header("Content-Type: application/json; charset=UTF-8");
  if (isset($_SESSION['login']))
  {
    destroySession();
    die(json_encode("230"));
  }
  else die(json_encode("240"));
?>