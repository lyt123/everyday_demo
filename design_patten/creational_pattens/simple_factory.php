<?php

/* User:lyt123; Date:2017/2/25; QQ:1067081452 */

interface Vehicle
{
    public function drive();
}

class Car implements Vehicle
{
    public function drive()
    {
        echo '汽车靠四个轮子滚动行走。';
    }
}

class Ship implements Vehicle
{
    public function drive()
    {
        echo '轮船靠螺旋桨划水前进。';
    }
}

class Aircraft implements Vehicle
{
    public function drive()
    {
        echo '飞机靠螺旋桨和机翼的升力飞行。';
    }
}

class VehicleFactory
{
    public static function build($className = null)
    {
        $className = ucfirst($className);
        if ($className && class_exists($className)) {
            return new $className();
        }
        return null;
    }
}

//this way, no more need to new a class
VehicleFactory::build('Car')->drive();
VehicleFactory::build('Ship')->drive();
VehicleFactory::build('Aircraft')->drive();