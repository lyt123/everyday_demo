<?php
//使用MyMiniSmarty.class.php
require_once 'MyMiniSmarty.class.php';
$mysmarty=new MyMiniSmarty;

$mysmarty->assign("title","我的第一个文件title");
$mysmarty->assign("content","我的第一个文件内容");
$mysmarty->display("intro.tpl");