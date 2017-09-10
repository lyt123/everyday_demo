<?php
interface Middleware
{
    public static function handle(Closure $next);
}

class VerifyCsrfToken implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "验证csrf-token.......";
        $next();
    }
}

class ShareErrorsFromSession implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "如果session中有errors变量，共享他....";
        $next();
    }
}

class StartSession implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "开启session,获取数据....";
        $next();
        echo "保存数据，关闭session..";

    }
}

class AddQueuedCookiesToResponse implements Middleware
{
    public static function handle(Closure $next)
    {
        $next();
        echo "添加下一次请求需要的cookie...";
    }
}

class EncryptCookies implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "对输入请求的cookie进行解密...";
        $next();
        echo "对输出响应的cookie进行加密...";
    }
}

class CheckForMaintenanceMode implements Middleware
{
    public static function handle(Closure $next)
    {
        echo "确定当前程序是否处于维护状态...";
        $next();
    }
}

function getSlice()
{
    return function ($stack, $pipe) {
        return function () use ($stack, $pipe) {
            return $pipe::handle($stack);
        };

    };
}

function then()
{
    $pipes= [
        "CheckForMaintenanceMode",
        "EncryptCookies",
        "AddQueuedCookiesToResponse",
        "StartSession",
        "ShareErrorsFromSession",
        "VerifyCsrfToken"
    ];
    $firstSlice = function () {
        echo "请求向路由器传递，返回响应....";
    };
    $pipes = array_reverse($pipes);
    call_user_func(
        //这里如果写成'getSlice'，需要将上面的getSlice()函数更改为跟pipeline_simplify.php中的那种套路
        array_reduce($pipes, getSlice(), $firstSlice)
    );
//    equal to bellow
//    $go = array_reduce($pipes, getSlice(), $firstSlice);
//    $go();
}

then();