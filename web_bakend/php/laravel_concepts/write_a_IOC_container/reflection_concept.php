<?php
/* User:lyt123; Date:2017/4/25; QQ:1067081452 */
interface Pay
{
    public function pay();
}

class Alipay implements Pay {
    public function __construct(){}

    public function pay()
    {
        echo 'pay bill by alipay';
    }
}

class PayBill {

    private $payMethod;

    public function __construct( Pay $payMethod)
    {
        $this->payMethod= $payMethod;
    }

    public function  payMyBill()
    {
        $this->payMethod->pay();
    }
}

$reflection = new ReflectionClass('PayBill');

$constructor = $reflection->getConstructor();

$dependency_parameters = $constructor->getParameters();

//most important step : get 'Pay' from 'payMethod'
$dependency_parameter = $dependency_parameters[0];
$dependency_class = $dependency_parameter->getClass();

$b = new Alipay();

$instance = $reflection ->newInstanceArgs( [ $b ]);

var_dump($reflection, "<br/>", $constructor, "<br/>", $dependency_parameters, "<br/>",$dependency_class, "<br/>", $instance, "<br/>");
$instance->payMyBill(); //输出 'pay bill by alipay'
