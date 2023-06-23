<?php

    class router {
        private $pages = array();

        function add_route($url, $path){
            $this->pages[$url] = $path;
        }

        function route($url){
            if(!array_key_exists($url, $this->pages)){
                require "404.php";
                die();
            }
            $path = $this->pages[$url];
            $file_dir = $path;
            if($path == ""){
                require "404.php";
                die();
            }
            if(file_exists($file_dir)){
                require $file_dir;
            }
            else {
                require "404.php";
                die();
            }
        }
    }


?>