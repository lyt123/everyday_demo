<?php
require_once("Encoding.php");

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
//exit(iconv('GBK', 'utf-8', 'ç¬¬1-7å¨ææäºç¬¬1ã2è'));
var_dump(Encoding::fixUTF8('��Xێ�6}n����Ĳ��:�"��n�<�1bEiid�K� I������%��ζ���X��f�g��ã��T�y�@�0�Ls9�R 1���u����I��J)$����� �^��w���\'���jB猯z��9}6���g�f��@��	.do�2 �)��fRY\u��ۍ��u�o��z�F��?�a�I���Co> zˢ�|w�ۗ�O9B�㻴�/��@F�mJ��RwflWk@>Y7��0�2:�=���ִ)�Z ���+�\cNE��&���d2"cMu�H�^Ƕ|P��RD��f$��C�\'�!&�� �Ld�)"��S�İDbI!�T��{��S��3:Y�p��#����A������O�3�#�F�X�b���D�9^ �!�DlJ�R*h�|��F_�!l����̆�H�$?��J�~:gAz�0@ �/��+�	���˛�0ȑ��TԦ!�Lk���2d��љ� ������Ġ"�l�kr&���1�ДRd��P���f��r�Sj(�{�eL�D�9I �0� �:E��#��<�`�a�C4/`��q��.c������k^�o�9F�r'));
