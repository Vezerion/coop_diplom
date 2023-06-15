<?php 
    require_once 'functions.php';
    header("Content-Type: application/json; charset=UTF-8");

    session_start();
    //$_SESSION = json_decode(file_get_contents('php://input'), true);
    if(isset($_SESSION['login'])){
        
        $login = $_SESSION['login'];
        
        $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetch(PDO::FETCH_BOTH);
        $user_id = $user_id[0];
        
        $profile_data = queryMysql("SELECT username, name, surname, date_of_birth, country, city, phone FROM prolife WHERE user_id = '$user_id'")->fetch(PDO::FETCH_BOTH);
        $user_data = queryMysql("SELECT login, email FROM user WHERE login = '$login'")->fetch(PDO::FETCH_BOTH);

        die(json_encode($user_data, $profile_data));
    }
    else{
        die(json_encode("237"));
    }

?>