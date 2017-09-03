<?php
/* User:lyt123; Date:2017/8/21; QQ:1067081452 */
//1 diffent between php5.6 and php7
function test(/*int */
    ...$params)
{
    var_dump($params[0]['key']);
}

test(['key' => '23haha'], 32, true, 23.21);

//2
function test_function(callable $callback_funciton)
{
    echo 'a function is the first citizen of object in php';
    $callback_funciton();
}

//test_function(function () {
//    echo 'yes, it works';
//});

//3
interface checker
{
}

class cake implements checker
{
}

class salad extends cake
{
}

function restaurant(checker $food)
{
    var_dump($food);
}

$box = new salad();

//restaurant($box);

//4
class people
{
    function accept_people(self $people)
    {
        var_dump($people);
    }
}

class animal
{

}

$ivan = new people();

$guildon = new people();

$ivan->accept_people($guildon);

//$ivan->accept_people(new animal());

echo "\u{169}";
echo "&amp";

//5 php7 only, callabel can be replaced by self/integer/string/bool/float
//function data_return():callable
//{
//    echo "do something\n";
//    return function () {
//        echo 'yes';
//    };
//}

//$return_function = data_return();
//$return_function();

//6
//$b = 'i have a value';
//echo $a ?? $b ?? 'a and b are not exist';

//-1 less than
//0 eaual
//1 great than
//$spaceshipOperator = 2 <=> '2';

define('IVAN', array('age' => 18, 'handsome boy', 'two_dimension_array' => ['key' => 'nice']));

var_dump(IVAN['age']);
var_dump(IVAN['two_dimension_array']['key']);

//7 anonymous
class myObj
{

}

interface myInterface
{

}

$anonymous_class = new class('construct parameter') extends myObj implements myInterface{
    private $xxx;

    function __construct($param)
    {
        echo $param;
    }

    //default to public function
    static function hello()
    {
        echo 'yes';
    }
};

//8 unknown of the practical usage, i just think the following example magic

/*$context = function () {
    echo $this->property;
};

class newObj {
    public $property = 'hello world';
}

$context->call(new newObj());

//output : 'hello world'*/

$context = function ($param) {
    var_dump($param);
    echo $param->property;
};

class newObj {
    public $property = 'hello world';
}

call_user_func($context, new newObj());

//9 assert
/*ini_set('assert.exception', 1);
class HandleError extends AssertionError{
    function __construct()
    {
        var_dump('wrong happens');
    }
}

$num = 100;
assert($num > 500, new HandleError('some error text'));*/

//echo intdiv(10, 3);  //3
//echo 10/'3';         //3.3333

//echo random_bytes(5);//php7 only, can be used to generate salt

//echo random_int(1000, 10000);

/*preg_replace_callback_array(
    [
        '/[a]+/i' => function ($match) {
            //if matches, the function will be execute. the times matches and funciton executes are consistent
            echo 'match found for a ' . $match[0] . '<br/>';
        },
        '/[b]+/i' => function ($match) {
            echo 'match found for a ' . $match[0] . '<br/>';
        }
    ],
    'Aaaaaaa aa Bhh bb',
    1,//the times match,  -1 means try as much as you can
    $num_of_matches
);

echo $num_of_matches.'<br/>';*/

//9 generator : like a car, when it comes in front of the red light, it stops
function startNav()
{
    $distance = 0;

    echo '1';
    yield '2';
    echo '3';
    yield '4';
    echo '5';
    echo $distance;
}

$control = startNav();      //yield exists, a generator object is assigned to $control

echo $control->current();
echo 'up is the fist yield value';

$control->next();           //doesn't return value

echo $control->current();
echo 'up is the second yield value';

$control->next();

echo '<br/>below are the generator send function<br/>';

function startDrive()
{
    $distance = '0';
    echo '1' . $distance;
    $distance = yield;
    echo '2' . $distance;
    $distance = yield;
    echo '3' . $distance;
}

$control = startDrive();
$control->current();
echo 'analysing distance';
$control->send('50');
echo 'analysing distance';
$control->send('80');






























