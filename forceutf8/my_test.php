<?php
require_once ("Encoding.php");

use ForceUTF8\Encoding;

//fix the messy code to utf-8 encoding
//$string = "FÃÂ©dération Camerounaise de Football\n";
//$utf8_string = Encoding::fixUTF8($string);

//turn the file encoded with other code into utf-8
$string = file_get_contents("test/data/test1Latin.txt");
$utf8_string = Encoding::toUTF8($string);
var_dump(Encoding::fixUTF8('鍒樹匠鑰佸笀鏁欏浠诲姟涔?xls'));
echo 'ç¬¬1-7å¨ææäºç¬¬1ã2è';
echo "<br>";
exit(iconv('GBK', 'utf-8', 'ç¬¬1-7å¨ææäºç¬¬1ã2è'));
