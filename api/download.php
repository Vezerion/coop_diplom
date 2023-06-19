<?php 
    
    require_once 'functions.php';
    header("Content-Type: application/octet-stream; charset=UTF-8");
    session_start();
    $file = file_get_contents('php://input');
    //header("Content-Disposition: attachment; filename=$file");
    

    if(!isset($_SESSION['login'])){
        http_response_code(240);
        die();
    }
    
    $login = $_SESSION['login'];
    $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetchColumn();
    $dir_id = queryMysql("SELECT dir_id FROM user_has_files WHERE user_id = '$user_id'")->fetchColumn();
    $file_size = queryMysql("SELECT filesize FROM storage WHERE filename = '$file' AND dir_ID='$dir_id'")->fetchColumn();
    $filename =  "/var/www/j-5cloud/api/var/www/usr/$dir_id/$file";
    
    if (file_exists($filename)) {
        header("Content-Disposition: attachment; filename=$file");
        header("Content-Length: " . $file_size);
        flush();
        readfile($filename);
        http_response_code(230);
        die();
    } else {
        http_response_code(237);
        die();
    }
?>