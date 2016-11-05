<?php
/* User:lyt123; Date:2016/11/5; QQ:1067081452 */
$data = [1, 3, 4, 6];
foreach ($data as $item) {
    if ($item > 3)
        var_dump($item);
    else
        continue;
}
//output : 4  6
//this proves that continue will stop the foreach loop when the loop comes to the end