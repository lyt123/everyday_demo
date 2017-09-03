<?php
/* User:lyt123; Date:2016/11/16; QQ:1067081452 */
//There are many tests bellow
/*test 1*/
//preg_match_all("|(<[^>]+>).*</[^>]+>|U",
//    "<b>example: </b><div align=left>this is a test</div>",
//    $out, PREG_SET_ORDER);
//var_dump($out);exit();
/*test 2*/
//preg_match_all("/
//\(?  (\d{3})?  \)?
//  (?(1)  [\-\s] )
//   \d{3}-\d{4}
///x",
//    "Call 555-1212 or 1-800-555-1212", $phones);
//var_dump($phones);
/*test 3*/
//$regex = "/[a-zA-Z]+ \d+/";
//$data = preg_match_all($regex, "June 24", $out);
//var_dump($out);
/*test 4*/
//$pattern = "/[a-zA-Z]+ (\d+)/";
//$input_str = "June 24, August 13, and December 30";
//$data = preg_match_all($pattern, $input_str, $out, PREG_SET_ORDER);
//var_dump($data);
//var_dump($out);
/*test 5*/
//$regex = "/([a-zA-Z]+) (\d+)/";
//$new_string = preg_replace($regex, "$2 of $1", "June 24");
//var_dump($new_string);
/*test 6*/
//$text = 'abcdefghijklmnopqrst';
//$newfilename = preg_match('/ij(.*?)mn/', $text, $out);
//echo $out[0];
//echo "<br/>";
//echo $out[1];
/*test 7*/
//$text = 'abc@*&^)($%';
//preg_match_all('/[^a-zA-Z0-9.]/',$text,$out);
//var_dump($out);
/*test 7*/
//$text = 'ab2sq)(&*(%$%^$@%n23f9';
//$variable = preg_replace('/[^a-zA-Z0-9.]/','a',$text);
//var_dump($variable);
/*test 8*/
//$text = 'Hi, its me, Niko from Austria';
//$variable = preg_replace('/(Niko.*?) from/', '$1 Gomez', $text);
//var_dump($variable);
/*test 9*/
//$text = 'hi, my site is http://example.com, and on my page, at http://example.com/page37/blabla.html i wrote something..';
//preg_match_all("/[[:alpha:]]+:\/\/[^<>[:space:]]+[[:alnum:]\/]/",$text, $out);
//var_dump($out);
/*test 10*/
//$text = 'hi, my site is http://example.com, and on my page, at http://example.com/page37/trid.html i wrote something..';
//$variable = preg_replace("/[[:alpha:]]+:\/\/[^<>[:space:]]+[[:alnum:]\/]/",'<a href="\\0">\\0</a>', $text);
//var_dump($variable);
$text = "a23983298";
preg_match("/[a-zA-Z]{1}([0-9]|[_.]){5,10}/", $text, $result);
var_dump($result);















