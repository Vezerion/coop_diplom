<?php

    require "api/routing.php";
    session_start();
    function get_request_page_path() {
        $query = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        return $query;
    }

    
    $r = new router();

    if(isset($_SESSION['login'])){
        $r->add_route("/", "home.html");
        $r->add_route("/home", "home.html");
        $r->add_route("/account", "account.html");
        
    }
    else{
        $r->add_route("/", "home.html");
        $r->add_route("/home", "home.html");
        $r->add_route("/login", "login.html");
    }
   
    $r->route(get_request_page_path());
   

?>