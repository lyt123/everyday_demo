<?php

/* User:lyt123; Date:2017/2/25; QQ:1067081452 */

class carFactory
{

    public function __construct()
    {
        // ... //
    }

    public static function build($type = '')
    {

        if ($type == '') {
            throw new Exception('Invalid Car Type.');
        } else {

            $className = 'car_' . ucfirst($type);

            // Assuming Class files are already loaded using autoload concept
            if (class_exists($className)) {
                return new $className();
            } else {
                throw new Exception('Car type not found.');
            }
        }
    }
}

class car_Sedan
{
    public function __construct()
    {
        echo "Creating Sedan";
    }
}

class car_Suv
{

    public function __construct()
    {
        echo "Creating SUV";
    }

}

// Creating new Sedan
$sedan = carFactory::build('sedan');

// Creating new SUV
$suv = carFactory::build('suv');