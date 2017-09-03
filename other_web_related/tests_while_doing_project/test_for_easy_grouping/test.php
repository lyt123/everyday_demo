<?php
/* User:lyt123; Date:2017/8/30; QQ:1067081452 */
$date = DateTime::createFromFormat('U', time());
echo $date->format('Y-m-d H:i:s');
