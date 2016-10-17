<?php
/* trim functions aims to trim $hello from the begining or from the end or from both
 * and will trim every single character in "Hdle"
 */
$hello = "Hello World";
var_dump(trim($hello, "Hdle")); //output 'o Wor'
var_dump(rtrim($hello, "Hdle"));//output 'Hello Wor'
var_dump(ltrim($hello, "Hdle"));//output 'o World'

$hello = "Hello Woerld";
var_dump(trim($hello));
//output "o Woer", this means from the end, when it come across with 'r', trim stops
//rtrim -> right trim, ltrim -> left trim

