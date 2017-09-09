<?php
namespace App\Http\Controllers;
use App\Models\Articles;
use Illuminate\Container\Container;

class WelcomeController
{
    public function index()
    {
        $article = Articles::first();
        $data = $article->getAttributes();
//        return "内容是{$data['content']}";

        $app = Container::getInstance();
        $factory = $app->make('view');
        return $factory->make('welcome')->with('data', $data);
    }
}