<?php
require_once ("Encoding.php");

use ForceUTF8\Encoding;

//$string = "FÃÂ©dération Camerounaise de Football\n";
//$utf8_string = Encoding::fixUTF8($string);//fix the messy code to utf-8 encoding
$string = file_get_contents("test/data/test1Latin.txt");
//$utf8_string = Encoding::fixUTF8($string);
$utf8_string = Encoding::toUTF8($string);

die($utf8_string);