<?php 
    require_once 'functions.php';
    header("Content-Type: application/json; charset=UTF-8");

    session_start();
    $_SESSION = json_decode(file_get_contents('php://input'), true);
    if(isset($_SESSION['login'])){
        $login = $_SESSION['login'];
        $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetch(PDO::FETCH_BOTH);
        $user_id = $user_id[0];
        $file_path = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user_id'")->fetch(PDO::FETCH_BOTH);
        
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
        
        
        die(json_encode('230'.$output));
    }
    else {
        die(json_encode("237"));
    }

?>
