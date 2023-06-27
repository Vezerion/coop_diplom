<?php 
    require_once 'functions.php';
    header("Content-Type: application/json; charset=UTF-8");
    session_start();
    if (!check_session()){
        http_response_code(240);
        die();
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data = json_decode(file_get_contents('php://input'), true);
    }
    else{
        http_response_code(239);
        die();
    }

    if(check_session() && isset($data)){
        
        $login = $_SESSION['login'];
        $get_user_data = queryMysql("SELECT user_id, login, email FROM user WHERE login = '$login'")->fetch(PDO::FETCH_LAZY);
        
        $profile_data = queryMysql("SELECT username, name, surname, date_of_birth, country, city, phone FROM profile WHERE user_id = '$get_user_data->user_id'")->fetch(PDO::FETCH_ASSOC);
        $user_data = queryMysql("SELECT login, email FROM user WHERE login = '$login'")->fetch(PDO::FETCH_ASSOC);
        $output = $profile_data + $user_data;
        echo json_encode($output);
        http_response_code(230);
        die();
    }
    else{
        http_response_code(237);
        die();
    }

?>