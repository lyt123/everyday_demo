<?php
/* User:lyt123; Date:2017/2/6; QQ:1067081452 */
$email = 'Ivan@example.com';
echo filter_var($email, FILTER_SANITIZE_EMAIL);

$input = '<p><script>alert("You won the Nigerian lottery!");</script></p>';
echo htmlentities($input, ENT_QUOTES, 'UTF-8');

$string = "\nIñtërnâtiônàlizætiøn\t";
$safeString = filter_var(
    $string,
    FILTER_SANITIZE_STRING,
    FILTER_FLAG_STRIP_LOW|FILTER_FLAG_ENCODE_HIGH
);

//php fliter_var() function has few usages, but for more powerful data sanitize, use php components from packagist.org
