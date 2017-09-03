<?php

/* User:lyt123; Date:2017/2/25; QQ:1067081452 */

class Person
{
    private $name = 'Human';

    public function getName()
    {
        return $this->name;
    }
}
class Life
{
    public $persons = [];

    public function addPerson(Person $person)
    {
        $this->persons[] = $person;
    }
}

$class = new Life();
$class->addPerson(new Person);
$class->addPerson(new Person);

var_dump($class->persons);
//output:
//array (size=2)
//  0 =>
//    object(Person)[2]
//      private 'name' => string 'Human' (length=5)
//  1 =>
//    object(Person)[3]
//      private 'name' => string 'Human' (length=5)