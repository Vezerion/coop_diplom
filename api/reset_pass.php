<?php #reset password

    require_once 'functions.php';

    $new_pass = $user_login = $user_email = $user_new_pass = "";
    
    if ($loggedin) {
        $login = $_SESSION['login'];
        if (isset($_POST['new_pass'])){
            $new_pass = sanitizeString($_POST['new_pass']);
            $new_pass = preg_replace('/\s\s+/', ' ', $new_pass);
            if(!checkPass($new_pass)){
                echo "The password must contain uppercase and lowercase letters , numbers and be at least 8 characters\n";       
            }
            else{
                $query = $pdo->query("SELECT user_id FROM user WHERE login='$login'")->fetch(PDO::FETCH_BOTH);
                $user_id = $query[0];
                $new_pass = hash('md5', $new_pass);
                queryMysql("UPDATE user SET userpass='$new_pass' WHERE user_id='$user_id'");
                echo "Password was changed! <br>";
            }
        }
    }
    else{
        if (isset($_POST['user_login']) || isset($_POST['user_email']) || isset($_POST['user_new_pass'])){
            $user_login = sanitizeString($_POST['user_login']);
            $user_email = sanitizeString($_POST['user_email']);
            $user_new_pass = sanitizeString($_POST['user_new_pass']);

            $result = queryMySQL("SELECT login, email FROM user
            WHERE login='$user_login' AND email='$user_email' ")->fetch(PDO::FETCH_BOTH);

            if ($result[0] == $user_login && $result[1] == $user_email){
                if(!checkPass($user_new_pass)){
                    echo "The password must contain uppercase and lowercase letters , numbers and be at least 8 characters\n";       
                }
                else{
                    $query = $pdo->query("SELECT user_id FROM user WHERE login='$user_login'")->fetch(PDO::FETCH_BOTH);
                    $user_id = $query[0];
                    $user_new_pass = hash('md5', $user_new_pass);
                    queryMysql("UPDATE user SET userpass='$user_new_pass' WHERE user_id='$user_id'");
                    echo "Password was changed! <br>";
                }
            }

        }
    }

    

?>