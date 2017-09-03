<?php
if(rand(1, 3) == 1){
    /* Fake an error */
    header("HTTP/1.0 404 Not Found");
    die();
}

echo("Hi! Have a random number: ".rand(1, 10));











