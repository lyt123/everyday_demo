<?php
/* User:lyt123; Date:2016/11/1; QQ:1067081452 */
$array = [
    [1, 3, 5],
    [2, 3, 4]
];
foreach($array as $item) {
    var_dump($item);
    if($item[0] == 2)
        continue;
    echo 'haha';
}

//output
/*
array (size=3)
  0 => int 1
  1 => int 3
  2 => int 5
haha
array (size=3)
  0 => int 2
  1 => int 3
  2 => int 4
*/
//conclusion: continue works on foreach