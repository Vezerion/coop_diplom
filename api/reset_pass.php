<?php #reset password

    require_once 'functions.php';
    
    header("Content-Type: application/json; charset=UTF-8");
    
    session_start();

    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["reset_password"]) && isset($_SESSION['login'])) {
        $data = json_decode(file_get_contents('php://input'), true);
        
        $email = sanitizeString($data['email']);
        $login = sanitizeString($data['login']);
        $new_pass = sanitizeString($_data['new_pass']);
        $sql = queryMysql("SELECT userpass from user WHERE email = '$email' AND login = '$login'")->fetch(PDO::FETCH_LAZY);
        
        if (password_verify($new_pass, $sql->userpass) && checkPass($new_pass)){
            $sql_new_pass = queryMysql("UPDATE user SET userpass = '$new_pass' WHERE email = '$email' AND login = '$login'")->fetch(PDO::FETCH_LAZY);
            http_response_code(230);
        }
        else {
            http_response_code(235);
            die();
        }
        
    }
    else {
        http_response_code(240);
        die();
    }

?>