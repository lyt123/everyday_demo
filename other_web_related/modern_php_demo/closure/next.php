<?php
/* User:lyt123; Date:2017/2/6; QQ:1067081452 */
function enclosePerson($name) {
    return function ($do_command) use ($name) {
        return sprintf('%s, %s', $name, $do_command);
    };
}

$clay = enclosePerson('Ivan');

echo $clay('get me sweet tea!');
//Outputs --> "Ivan, get me sweet tea!"