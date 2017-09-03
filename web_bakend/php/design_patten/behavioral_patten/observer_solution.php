<?php
/* User:lyt123; Date:2017/2/26; QQ:1067081452 */
/**
 * 被观察者接口
 */
interface Observable
{
    // 添加/注册观察者
    public function attach(Observer $observer);
    // 删除观察者
    public function detach(Observer $observer);
    // 触发通知
    public function notify();
}

/**
 * 被观察者
 * 职责：添加观察者到$observers属性中，
 * 有变动时通过notify()方法运行通知
 */
class Order implements Observable
{
    // 保存观察者
    private $observers = array();
    // 订单状态
    private $state = 0;

    // 添加（注册）观察者
    public function attach(Observer $observer)
    {
        $key = array_search($observer, $this->observers);
        if ($key === false) {
            $this->observers[] = $observer;
        }
    }

    // 移除观察者
    public function detach(Observer $observer)
    {
        $key = array_search($observer, $this->observers);
        if ($key !== false) {
            unset($this->observers[$key]);
        }
    }

    // 遍历调用观察者的update()方法进行通知，不关心其具体实现方式
    public function notify()
    {
        foreach ($this->observers as $observer) {
            // 把本类对象传给观察者，以便观察者获取当前类对象的信息
            $observer->update($this);
        }
    }

    // 订单状态有变化时发送通知
    public function addOrder()
    {
        $this->state = 1;
        $this->notify();
    }

    // 获取提供给观察者的状态
    public function getState()
    {
        return $this->state;
    }
}

/**
 * 观察者接口
 */
interface Observer
{
    // 接收到通知的处理方法
    public function update(Observable $observable);
}

/**
 * 观察者1：发送邮件
 */
class Email implements Observer
{
    public function update(Observable $observable)
    {
        $state = $observable->getState();
        if ($state) {
            echo '发送邮件：您已经成功下单。';
        } else {
            echo '发送邮件：下单失败，请重试。';
        }
    }
}

/**
 * 观察者2：短信通知
 */
class Message implements Observer
{
    public function update(Observable $observable)
    {
        $state = $observable->getState();
        if ($state) {
            echo '短信通知：您已下单成功。';
        } else {
            echo '短信通知：下单失败，请重试。';
        }
    }
}

/**
 * 观察者3：记录日志
 */
class Log implements Observer
{
    public function update(Observable $observable)
    {
        echo '记录日志：生成了一个订单记录。';
    }
}

// 创建观察者对象
$email = new Email();
$message = new Message();
$log = new Log();
// 创建订单对象
$order = new Order();

// 向订单对象中注册3个观察者：发送邮件、短信通知、记录日志
$order->attach($email);
$order->attach($message);
$order->attach($log);
// 添加订单，添加时会自动发送通知给观察者
$order->addOrder();

echo '<br />';

// 删除记录日志观察者
$order->detach($log);
// 添加另一个订单，会再次发送通知给观察着
$order->addOrder();