<?php
/* User:lyt123; Date:2017/4/24; QQ:1067081452 */

//支付类接口
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


$pb->payMyBill();



