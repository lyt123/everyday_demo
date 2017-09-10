<?php
function object_dump($object, $show_methods = true)
{
    $EOL = php_sapi_name() == 'cli' ? PHP_EOL : '<br/>';
    $LS = php_sapi_name() == 'cli' ? '--------------------------' . PHP_EOL : '<hr/>';
    if (php_sapi_name() != 'cli') {
        echo "<pre>";
    }

    echo "Dump of object of class : " . get_class($object) . $EOL . $LS;

    if ($show_methods) {
        echo "Methods :" . $EOL;
        var_dump(get_class_methods($object));
        echo $LS;
    }

    echo "Properties :" . $EOL;

    foreach (get_object_vars($object) as $property => $value) {
        if (gettype($value) == "object") {
            $value = "object of " . get_class($value);
        }
        echo "$property : (" . gettype($value) . ") $value $EOL";
    }

    if (php_sapi_name() != 'cli') {
        echo "</pre>";
    }
}

function nice_print_r($data)
{
    echo '<pre>';
    print_r($data);
    echo '</pre>';
}


//容器类装实例或提供实例的回调函数
class Container
{

    //用于装提供实例的回调函数，真正的容器还会装实例等其他内容
    //从而实现单例等高级功能
    protected $bindings = [];

    //绑定接口和生成相应实例的回调函数
    public function bind($abstract, $concrete = null, $shared = false)
    {

        //如果提供的参数不是回调函数，则产生默认的回调函数
        if (!$concrete instanceof Closure) {
            echo 1;
            $concrete = $this->getClosure($abstract, $concrete);
        }

        //shared变量的意义在这里没有体现
        $this->bindings[$abstract] = compact('concrete', 'shared');
        var_dump('$bindings :');
        nice_print_r($this->bindings);
    }

    //默认生成实例的回调函数
    protected function getClosure($abstract, $concrete)
    {
        return function ($c) use ($abstract, $concrete) {
            //这个闭包方法在下面的build方法中$concrete($this)中才真正调用
            $method = ($abstract == $concrete) ? 'build' : 'make';
            var_dump($concrete, $abstract);
            var_dump('closure called');

            return $c->$method($concrete);
        };
    }

    public function make($abstract)
    {

        //PayBill
        $concrete = $this->getConcrete($abstract);

        var_dump('make parameter', $abstract, 'getConcrete:');

        nice_print_r($concrete);

        //isBuildable函数判断$abstract是否是$concrete的别名
        if ($this->isBuildable($concrete, $abstract)) {
            echo 3;
            $object = $this->build($concrete);
        } else {
            $object = $this->make($concrete);
        }
        var_dump('$object');
        object_dump($object);
        return $object;
    }

    protected function isBuildable($concrete, $abstract)
    {
        return $concrete === $abstract || $concrete instanceof Closure;
    }

    //获取绑定的回调函数
    protected function getConcrete($abstract)
    {

        if (!isset($this->bindings[$abstract])) {
            echo 2;
            return $abstract;
        }

        return $this->bindings[$abstract]['concrete'];
    }

    //实例化对象
    public function build($concrete)
    {
        //如果是闭包，说明已找到依赖的关系
        if ($concrete instanceof Closure) {
            var_dump('concrete instanceof closure');
            $data = $concrete($this);
            var_dump('closure finished');
            return $data;
        }

        $reflector = new ReflectionClass($concrete);

        if (!$reflector->isInstantiable()) {
            echo $message = "Target [$concrete] is not instantiable";
        }

        $constructor = $reflector->getConstructor();
        if (is_null($constructor)) {
            var_dump($concrete. ' has no constructor');
            return new $concrete;
        }

        //name => 'payMethod'
        $dependencies = $constructor->getParameters();
         var_dump('dependencys', $dependencies);

        $instances = $this->getDependencies($dependencies);
        $result = $reflector->newInstanceArgs($instances);
        return $result;
    }

    //解决通过反射机制实例化对象时的依赖
    protected function getDependencies($parameters)
    {
        $dependencies = [];
        foreach ($parameters as $parameter) {
            $dependency = $parameter->getClass();

            if (is_null($dependency)) {
                $dependencies[] = NULL;
            } else {

                $dependencies[] = $this->resolveClass($parameter);
            }
        }
        return (array)$dependencies;
    }

    protected function resolveClass(ReflectionParameter $parameter)
    {
        //Pay
        return $this->make($parameter->getClass()->name);
    }
}

//支付类接口
interface Pay
{
    public function pay();
}


//支付宝支付
class Alipay implements Pay
{
    //if you comment the below 3 lines, the debug result will be a bit easier
    public function __construct()
    {
    }

    public function pay()
    {
        echo 'pay bill by alipay';
    }
}

//微信支付
class Wechatpay implements Pay
{
    public function __construct()
    {
    }

    public function pay()
    {
        echo 'pay bill by wechatpay';
    }
}

//银联支付
class Unionpay implements Pay
{
    public function __construct()
    {
    }

    public function pay()
    {
        echo 'pay bill by unionpay';
    }
}

//付款
class PayBill
{

    private $payMethod;

    public function __construct(Pay $payMethod)
    {
        $this->payMethod = $payMethod;
    }

    public function payMyBill()
    {
        $this->payMethod->pay();
    }
}

//生成依赖
//$payMethod =  new Unionpay();
//注入依赖
//$pb = new PayBill( $payMethod );
//$pb->payMyBill();

$app = new Container();

$app->bind("Pay", "Alipay");//Pay 为接口， Alipay 是 class Alipay

//example one
//$app->bind("tryToPayMyBill", "PayBill"); //tryToPayMyBill可以当做是Class PayBill 的服务别名
//$paybill = $app->make("tryToPayMyBill");//通过字符解析，或得到了Class PayBill 的实例
//$paybill->payMyBill();

//example two
$paybill = $app->make('PayBill');
$paybill->payMyBill();