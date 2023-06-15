<?php
    $host = 'localhost';
    $data = 'j-5cloud';
    $user_id = '';
    $username = 'root';
    $pass = 'root';
    $chrs = 'utf8';
    $attr = "mysql:host=$host; dbname=$data; charset=$chrs";
    $opts =
    [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    try{
        $pdo = new PDO($attr, $username, $pass, $opts);
    }
    catch (PDOException $e){
        throw new PDOException($e->getMessage(), (int)$e->getCode());
    }
    
    function queryMysql($query){
        global $pdo;
        return $pdo->query($query);
    }
    
    function destroySession(){
        //$_SESSION=array();
    
        if (session_id() != "" || isset($_COOKIE[session_name()]))
          setcookie(session_name(), '', time()-2592000, '/');
        session_destroy();
    }
    
    function sanitizeString($var){
        global $pdo;
    
        $var = strip_tags($var);
        $var = htmlentities($var);
    
        $result = $pdo->quote($var);          // This adds single quotes
        return str_replace("'", "", $result); // So now remove them
    }

    function checkPass($user_pass){
        if(strlen($user_pass) < 8){
            return false;
        }
        elseif(preg_match("/[a-z]/", $user_pass) && preg_match("/[A-Z]/", $user_pass) && preg_match("/[0-9]/", $user_pass))
        {
            return true;
        }
    }

    function GenUserID(){
        $uniq_id = (string)microtime(true);
        $uniq_id_array = explode(".", $uniq_id);
        return substr($uniq_id_array[0] . $uniq_id_array[1], 6, 12);
    }

    function email_valid($email){
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return true;
          } else {
            return false;
          }
    }
?>