<?php
/* User:lyt123; Date:2017/2/25; QQ:1067081452 */
//origin
class Alipay
{
    public function sendPayment()
    {
        echo '使用支付宝支付。';
    }
}

// 客户端代码
$alipay = new Alipay();
$alipay->sendPayment();

//promote
interface PayAdapter
{
    public function pay();
}
class AlipayAdapter implements PayAdapter
{
    public function pay()
    {
        // 实例化Alipay类，并用Alipay的方法实现支付
        $alipay = new Alipay();
        $alipay->sendPayment();
    }
}
// 客户端代码
$alipay = new AlipayAdapter();
// 用pay()方法实现支付
$alipay->pay();

//more promote(add weChat pay)
/**
 * 微信支付类
 */
class WechatPay
{
    public function scan()
    {
        echo '扫描二维码后，';
    }

    public function doPay()
    {
        echo '使用微信支付';
    }
}

/**
 * 微信支付适配器
 */
class WechatPayAdapter implements PayAdapter
{
    public function pay()
    {
        // 实例化WechatPay类，并用WechatPay的方法实现支付。
        // 注意，微信支付的方式和支付宝的支付方式不一样，但是
        // 适配之后，他们都能用pay()来实现支付功能。
        $wechatPay = new WechatPay();
        $wechatPay->scan();
        $wechatPay->doPay();
    }
}

// 客户端代码
$wechat = new WechatPayAdapter();
// 也是用pay()方法实现支付
$wechat->pay();