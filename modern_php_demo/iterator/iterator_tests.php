<?php
/* User:lyt123; Date:2017/2/24; QQ:1067081452 */
/* use of ArrayIterator */
$b = array(
    'name'=> 'mengzhi',
    'age' => '12',
    'city'=> 'shanghai'
);

$a = new ArrayIterator($b);
$a->append(array(
    'home' => 'china',
    'work' => 'developer'
));
$c = $a->getArrayCopy();
print_r($a);
print_r($c);

/* use of send() */
function nums() {
    for ($i = 0; $i < 5; ++$i) {
        //get a value from the caller
        $cmd = (yield $i);
        if($cmd == 'stop')
            return;//exit the function
    }
}
$gen = nums();
foreach($gen as $v)
{
    if($v == 3)//we are satisfied
        $gen->send('stop');
    echo "{$v}\n";
}

/* yield can be used to accept data */
function logger($fileName) {
    $fileHandle = fopen($fileName,'a');
    while(true) {
        fwrite($fileHandle,yield . "\n");
    }
}
$logger = logger(__DIR__.'/log');
var_dump($logger->send('Foo'));
var_dump($logger->send('Bar'));

