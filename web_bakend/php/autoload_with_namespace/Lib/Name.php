<?php
/* User:lyt123; Date:2017/3/10; QQ:1067081452 */
namespace Lib;
class Name
{
    public function __construct()
    {
        echo __NAMESPACE__ . "<br>";
    }
    public static function test()
    {
        echo  __NAMESPACE__ . ' static function test <br>';
    }
}