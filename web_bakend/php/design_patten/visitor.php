<?php

# by using visitor pattern
# once there's other one Action, what need to do is just add one Action, and display in the client
# this pattern requires that the Person type to be stable, not changed

abstract class Action
{
    abstract function getManConclusion();

    abstract function getWomanConclusion();
}

class Success extends Action
{
    function getManConclusion()
    {
        echo '男人成功时';
    }

    function getWomanConclusion()
    {
        echo '女人成功时';
    }
}

class Love extends Action
{
    function getManConclusion()
    {
        echo '男人恋爱时';
    }

    function getWomanConclusion()
    {
        echo '女人恋爱时';
    }
}

abstract class Person
{
    abstract function accept(Action $action);
}

class Man extends Person
{

    function accept(Action $action)
    {
        $action->getManConclusion();
    }
}

class Woman extends Person
{

    function accept(Action $action)
    {
        $action->getWomanConclusion();
    }
}

class Structure
{
    public $persons = [];

    function addPerson(Person $person)
    {
        $this->persons[] = $person;
    }

    function display(Action $action)
    {
        foreach ($this->persons as $person) {
            $person->accept($action);
        }
    }
}

$structure = new Structure();
$structure->addPerson(new Man());
$structure->addPerson(new Woman());
$structure->display(new Success());
$structure->display(new Love());
