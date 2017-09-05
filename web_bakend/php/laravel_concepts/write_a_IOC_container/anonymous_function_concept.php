<?php
/* User:lyt123; Date:2017/5/21; QQ:1067081452 */
//helps to understand the $bindings[] in laravel IOC_Container
$data1 = 'a';
$data2 = 'a means b';

$test = function () use ($data1, $data2) {

};

var_dump($test);
//output:
/*
object(Closure)[1]
  public 'static' =>
    array (size=2)
      'data1' => string 'a' (length=1)
      'data2' => string 'a means b' (length=9)
*/

$test = function ($c) use ($data1, $data2) {

};

var_dump($test);
//output:
/*
object(Closure)[1]
  public 'static' =>
    array (size=2)
      'data1' => string 'a' (length=1)
      'data2' => string 'a means b' (length=9)
  public 'parameter' =>
    array (size=1)
      '$c' => string '<required>' (length=10)
*/

class Test
{
    public $test = [];

    public function test()
    {
        $data1 = $data2 = 3;
        return function ($c) use ($data1, $data2) {

        };
    }
}

var_dump((new Test())->test());
//output: //attention:this is automatic bind into the closure
/*
object(Closure)[3]
  public 'static' =>
    array (size=2)
      'data1' => int 3
      'data2' => int 3
  public 'this' =>
    object(Test)[1]
      public 'test' =>
        array (size=0)
          empty
  public 'parameter' =>
    array (size=1)
      '$c' => string '<required>' (length=10)
*/