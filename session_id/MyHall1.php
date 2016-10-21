<?php

if (isset($_GET['PHPSESSID']))
{
    $sid=session_id($_GET['PHPSESSID']);
}
session_start();

//购物大厅
echo "<h1>欢迎购买</h1>";
echo "<a href='ShowProcess1.php?bookid=sn001&bookname=红楼梦&".SID."'>红楼梦</a><br/>";
echo "<a href='ShowProcess1.php?bookid=sn003&bookname=西游记&".SID."'>西游记</a><br/>";
echo "<a href='ShowProcess1.php?bookid=sn004&bookname=聊斋&".SID."'>聊斋</a><br/>";
echo "<hr/>";
echo "<a href='ShowCart1.php?".SID."'>查看购买到的商品列表</a>";
