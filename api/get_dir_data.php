<?php 
    require_once 'functions.php';
    header("Content-Type: application/json; charset=UTF-8");
    header("Location: account.html");
    session_start();
    
    $_POST = json_decode(file_get_contents('php://input'), true);

    if(isset($_POST)){
        
        $login = sanitizeString($_POST['login']);
        $username = sanitizeString($_POST['username']);
        $email = sanitizeString($_POST['email']);
        
        $user = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetchColumn();
       // $user_id = $user_id[0];
        $dir_path = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user'")->fetchColumn();

        $output = queryMysql("SELECT filename FROM storage WHERE dir_ID = '$dir_path'")->fetchAll(PDO::FETCH_ASSOC);
        
        echo json_encode($output);
        
        die(http_response_code(230));
    }
    else {
        die(http_response_code(237));
    }

?>
