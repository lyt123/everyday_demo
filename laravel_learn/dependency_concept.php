<?php
/* User:lyt123; Date:2017/4/24; QQ:1067081452 */
/*//支付宝支付
class Alipay {
    public function __construct(){}

    public function pay()
    {
        echo 'pay bill by alipay';
    }
}
//微信支付
class Wechatpay {
    public function __construct(){}

    public function pay()
    {
        echo 'pay bill by wechatpay';
    }
}
//银联支付
class Unionpay{
    public function __construct(){}

    public function pay()
    {
        echo 'pay bill by unionpay';
    }
}

//支付账单
class PayBill {

    private $payMethod;

      public function __construct( )
      {
          $this->payMethod= new Unionpay ();
      }

      public function  payMyBill()
      {
          $this->payMethod->pay();
      }
}


$pb = new PayBill ();
$pb->payMyBill();*/

//进行依赖注入
/*//支付类接口
interface Pay
{
    public function pay();
}


//支付宝支付
class Alipay implements Pay {
    public function __construct(){}

    public function pay()
    {
        echo 'pay bill by alipay';
    }
}
//微信支付
class Wechatpay implements Pay  {
    public function __construct(){}

    public function pay()
    {
        echo 'pay bill by wechatpay';
    }
}
//银联支付
class Unionpay implements Pay  {
    public function __construct(){}

    public function pay()
    {
        echo 'pay bill by unionpay';
    }
}

//付款
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

//生成依赖
$payMethod =  new Unionpay();
//注入依赖
$pb = new PayBill( $payMethod );
$pb->payMyBill();*/
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