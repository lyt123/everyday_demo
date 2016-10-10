<?php
/*
 * enter "http://localhost/everyday_demo/roote/server" into url
 * will go in index.php(by .htaccess setting)
 * thus redirect to "http://localhost/everyday_demo/server/server_values"
*/
$path = ltrim($_SERVER['REQUEST_URI'], '/');// Trim leading slash(es)
$elements = explode('/', $path);// Split path on slashes
switch (array_pop($elements))// Pop off final item and switch, in this example, it's "server"
{
    case'long_polling':
        redirect('http://localhost/everyday_demo/long_polling/long_poller.html');
        break;
    case'server':
        redirect('http://localhost/everyday_demo/server/server_values.php');
        break;
    default:
        header('HTTP/1.1 404 Not Found');
        var_dump('nice');
}

function redirect($url, $statusCode = 301)
{
    header('Location:'.$url, true, $statusCode);
    die();//stop subsequent codes from executing
}
