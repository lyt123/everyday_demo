<?php
/* User:lyt123; Date:2017/2/6; QQ:1067081452 */
$closure = function ($name) {
    return sprintf('Hello %s', $name);
};

echo $closure("Ivan lin");
//Outputs --> "Hello Ivan lin"

$numbersPlusOne = array_map(function ($number) {
    return $number + 1;
}, [1,2,3]);
print_r($numbersPlusOne);
// Outputs --> [2,3,4]