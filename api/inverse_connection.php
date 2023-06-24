<?php
    require_once 'functions.php';
    date_default_timezone_set('Etc/GMT-3');
    header("Content-Type: application/json; charset=UTF-8");
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $data = json_decode(file_get_contents('php://input'), true);
    }
    else {
        http_response_code(239);
        die();
    }

    session_start();
    if (!check_session()){
        http_response_code(240);
        die();
    }
    $login = $_SESSION['login'];

    if(isset($data['feedback_msg'])){
        $feedback_msg = sanitizeString($data['feedback_msg']);
        $date_of_create = date("F j, Y, g:i a"); 
        $sql_to_user_tb = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetchColumn();
        $insert_feedback_tb = queryMysql("INSERT INTO feedback(user_id, feedback_msg, date_of_create) VALUES('$sql_to_user_tb','$feedback_msg', '$date_of_create')");

        http_response_code(230);
        die();
    }elseif(isset($data['tech_prob_msg'])){
        $tech_prob_msg = sanitizeString($data['tech_prob_msg']);
        $date_of_create = date("F j, Y, g:i a"); 
        $sql_to_user_tb = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetchColumn();
        $insert_feedback_tb = queryMysql("INSERT INTO feedback(user_id, tech_prob_msg, date_of_create)  VALUES('$sql_to_user_tb', '$tech_prob_msg', '$date_of_create')");

        http_response_code(230);
        die();
    }
    else {
        http_response_code(240);
        die();
    }
?>