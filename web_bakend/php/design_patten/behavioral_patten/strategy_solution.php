<?php
/* User:lyt123; Date:2017/2/26; QQ:1067081452 */
/**
 * 策略接口
 */
interface OutputStrategy
{
    public function render($array);
}

/**
 * 策略类1：返回序列化字符串
 */
class SerializeStrategy implements OutputStrategy
{
    public function render($array)
    {
        return serialize($array);
    }
}

/**
 * 策略类2：返回JSON编码后的字符串
 */
class JsonStrategy implements OutputStrategy
{
    public function render($array)
    {
        return json_encode($array);
    }
}

/**
 * 策略类3：直接返回数组
 */
class ArrayStrategy implements OutputStrategy
{
    public function render($array)
    {
        return $array;
    }
}

/**
 * 环境角色类
 */
class Output
{
    private $outputStrategy;

    // 传入的参数必须是策略接口的子类或子类的实例
    public function __construct(OutputStrategy $outputStrategy)
    {
        $this->outputStrategy = $outputStrategy;
    }

    public function renderOutput($array)
    {
        return $this->outputStrategy->render($array);
    }
}

/**
 * 客户端代码
 */
$test = ['a', 'b', 'c'];

// 需要返回数组
$output = new Output(new ArrayStrategy());
$data = $output->renderOutput($test);

// 需要返回JSON
$output = new Output(new JsonStrategy());
$data = $output->renderOutput($test);