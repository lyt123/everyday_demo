<?php
if (isset($_GET['PHPSESSID']))
{
    session_id($_GET['PHPSESSID']);
    var_dump('ShowCart1 sessionid exists');
}
session_start();

echo "<h1>购物车商品有</h1>";

foreach($_SESSION as $key=>$val)
{
    echo "<br/> 书号--$key 书名--$val";
}
echo "<br/><a href='MyHall1.php?".SID."'>返回购物大厅继续购买</a>";
