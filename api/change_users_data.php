<?php //доделать проверки:
    // проверка имени и фамилии
    // валидация почты

    require_once('functions.php');
    session_start();
    header("Content-Type: application/json; charset=UTF-8");
    
    if (isset($_SERVER["REQUEST_METHOD"]) == "POST")
        $data = json_decode(file_get_contents('php://input'), true);
    
    if (!isset($_SESSION['login'])){
        destroySession();
        http_response_code(240);
        die();
    }
  
    if (isset($data)){
        $login = $_SESSION['login'];
        
        $new_login = sanitizeString($data['login']);
        $new_login = preg_replace('/\s\s+/', ' ', $new_login);
        $new_email = sanitizeString($data['email']);
        $new_email = preg_replace('/\s\s+/', ' ', $new_email);
        
        $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetchColumn();
        
        
        if(!strcmp($new_login, queryMysql("SELECT login FROM user WHERE login != '$login'")->fetchColumn())){
            http_response_code(233);
            die();
        }
        
        if(!strcmp($new_email, queryMysql("SELECT email FROM user WHERE login != '$login'")->fetchColumn())){
            http_response_code(234);
            die();
        }
       

        $username = sanitizeString($data['username']);
        $username = preg_replace('/\s\s+/', ' ', $username);
        
        $name = sanitizeString($data['username']);
        $name = preg_replace('/\s\s+/', ' ', $name);
        
        $surname = sanitizeString($data['surname']);
        $surname = preg_replace('/\s\s+/', ' ', $surname);
        /*
        if (!email_valid($new_email) || 
            (preg_match("/[a-z]/", $name) && preg_match("/[A-Z]/", $name) && !empty($name)) || 
            (preg_match("/[a-z]/", $surname) && preg_match("/[A-Z]/", $surname) && !empty($surname))
        ){
          http_response_code(232);
          die();
        }
        */

        $date_of_birth = sanitizeString($data['date_of_birth']);
        $date_of_birth = preg_replace('/\s\s+/', ' ', $date_of_birth);
        if ($date_of_birth == "")
            $date_of_birth =  '1900-01-01';

        $phone = sanitizeString($data['phone']);
        $phone = preg_replace('/\s\s+/', ' ', $phone);

        queryMysql("UPDATE user SET login = '$new_login', email = '$new_email' WHERE user_id='$user_id'");
        queryMysql("UPDATE profile SET username = '$username', name='$name', surname='$surname', date_of_birth='$date_of_birth', phone='$phone' WHERE user_id='$user_id'");
        

        http_response_code(230);
        die();
    }  
    else {
        http_response_code(240);
        die();
    }

?>