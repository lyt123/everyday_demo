<?php
/* User:lyt123; Date:2017/4/10; QQ:1067081452 */
$list = new SplDoublyLinkedList();
$list->push('a');
$list->push('b');
$list->push('c');
$list->push('d');

var_dump($list);
echo "FIFO (First In First Out) :\n";
$list->setIteratorMode(SplDoublyLinkedList::IT_MODE_FIFO);
for ($list->rewind(); $list->valid(); $list->next()) {
    echo $list->current()."\n";
}
