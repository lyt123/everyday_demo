<?php
/* User:lyt123; Date:2017/4/25; QQ:1067081452 */
class B{

}


class A {

    public function __construct(B $args)
    {

    }

    public function dosomething()
    {
        echo 'Hello world';
    }
}

//建立class A 的反射
$reflection = new ReflectionClass('A');

$b = new B();

//获取class A 的实例
//$instance = $reflection ->newInstanceArgs( [ $b ]);

//$instance->dosomething(); //输出 ‘Hellow World’

$constructor = $reflection->getConstructor();//获取class A 的构造函数

$dependencies = $constructor->getParameters();//获取class A 的依赖类
var_dump(($reflection));

var_dump($constructor);

var_dump($dependencies);