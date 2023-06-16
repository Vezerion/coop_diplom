<?php 

    require_once 'functions.php';
    header("Content-Type: application/octet-stream");
    $login = $_SESSION['login'];
    $user_id = queryMysql("SELECT user_id FROM user WHERE login = '$login'")->fetch(PDO::FETCH_BOTH);
    $user_id = $user_id[0];
    $file_path = queryMysql("SELECT files_id FROM user_has_files WHERE user_id = '$user_id'")->fetch(PDO::FETCH_BOTH);

    if (isset($_GET['download_file'])){
        $filename = $_GET['downlaod_file'];
        flush();
        readfile($filename);
        die();
    }
?>