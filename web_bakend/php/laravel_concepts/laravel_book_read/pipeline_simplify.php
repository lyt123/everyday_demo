<?php
interface Step {
    public static function go(Closure $next);
}

class FirstStep implements Step {
    public static function go (Closure $next)
    {
        echo "开启session,获取数据...".'<br>';
        $next();
        echo "保存数据,关闭SESSION...".'<br>';
    }
}

class SecondStep implements Step {
    public static function go(Closure $next)
    {
        echo "检测用户权限";
        $next();
    }
}

function goFun($step,$className)
{
    return function() use($step,$className)
    {
        return $className::go($step);
    };
}

function then()
{
    $steps = ["FirstStep","SecondStep"];
    $prepare = function() { echo "请求向路由器传递，返回响应...".'<br>';};
    $go = array_reduce($steps,"goFun",$prepare);
    //第一个是要处理的数组，第二个是处理函数名称或回调函数，第三个是可选参数，为初始化参数，被当作数组中第一个值来处理，若数组为空则作为返回值。
    var_dump($go);//在postman中看看输出的结果
    $go();
}

then();