<?php
$app['router']->get('/', function () {
    return 'nice';
});
$app['router']->get('welcome', 'App\Http\Controllers\WelcomeController@index');
