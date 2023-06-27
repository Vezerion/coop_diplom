<?php
require_once 'functions.php';
    header("Content-Type: application/json; charset=UTF-8");
    json_check(json_last_error());
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
    if (isset($data)){
        $filename = $data['name'];
        $login = $_SESSION['login'];
        $user = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetchColumn();
        $dir_path = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user'")->fetchColumn();

        $output = queryMysql("SELECT filename, filesize, type, date_of_upload FROM storage WHERE dir_ID = '$dir_path' AND filename = '$filename'")->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($output);
        http_response_code(230);
        die();
    }
    else {
        http_response_code(237);
        die();
    }


?>