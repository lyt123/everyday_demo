<?php
$path = ltrim($_SERVER['REQUEST_URI'], '/');// Trim leading slash(es)
$elements = explode('/', $path);// Split path on slashes
switch (array_pop($elements))// Pop off first item and switch
{
    case'roote.php':
        redirect('http://localhost/everyday_demo/long_polling/long_poller.html');
        exit();
        break;
    case'more':
        redirect('localhost/everyday_demo/server_values.php');
        break;
    default:
        header('HTTP/1.1 404 Not Found');
//            redirect('http://github.com/lyt123/everyday_demo');
}

function redirect($url, $statusCode = 301)
{
    header('Location:'.$url, true, $statusCode);
    die();//stop subsequent codes from executing
}
