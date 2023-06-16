<?php 
    require_once 'functions.php';
    header("Content-Type: application/json; charset=UTF-8");

    session_start();
    $_POST = json_decode(file_get_contents('php://input'), true);
    if(isset($_POST)){
        $login = sanitizeString($_POST['login']);
        $username = sanitizeString($_POST['username']);
        $email = sanitizeString($_POST['email']);
        $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetch(PDO::FETCH_BOTH);
        $user_id = $user_id[0];
        $file_path = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user_id'")->fetch(PDO::FETCH_BOTH);
        $output = queryMysql("SELECT dir_ID, filename FROM storage WHERE dir_ID = 'c5ed6b3135310f17cec90e21d82fe67e'");//->fetch(PDO::FETCH_ASSOC);
        echo json_encode($output->fetchAll());
        /*
        if (is_dir("var/www/usr/$file_path[0]")) {
            if ($dir = opendir("var/www/usr/$file_path[0]")) {
                $i = 0;
                while (($file = readdir($dir)) !== false) {
                    if( $file=="." || $file=="..")continue;
                    $output[$i] = "$file";
                    ++$i;
                }
                closedir($dir);
            }
          }
        */
        //die(http_response_code(230));
    }
    else {
        die(http_response_code(237));
    }

?>
