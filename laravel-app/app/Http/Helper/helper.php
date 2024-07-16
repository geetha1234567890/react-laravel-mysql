<?php

if (!function_exists('p')){  //p-print
    function p($data){
        echo "<pre>";
        print_r($data);
        echo "</pre";
    }
}
