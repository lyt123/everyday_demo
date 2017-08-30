<?php
//定义当前的目录绝对路径
define('DIR', dirname(__FILE__));
//加载这个文件
require DIR . '/loading.php';
//采用`命名空间`的方式注册。php 5.3 加入的
//也必须是得是static静态方法调用，然后就像加载namespace的方式调用，注意：不能使用use
spl_autoload_register("\\AutoLoading\\loading::autoload");
// 调用三个namespace类
//定位到Lib目录下的Name.php
Lib\Name::test();
//定位到App目录下Android目录下的Name.php
App\Android\Name::test();
//定位到App目录下Ios目录下的Name.php
//App\Ios\Name::test();