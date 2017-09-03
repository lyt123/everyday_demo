<?php
/* User:lyt123; Date:2017/7/22; QQ:1067081452 */
function http_get($ch, $url, $header = false)
{

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => TRUE,            //表示需要response header
        CURLOPT_RETURNTRANSFER => TRUE, //不让拿到的内容直接打印出来
        CURLOPT_TIMEOUT => 600,            //设置超时时间为5分钟
        //		CURLOPT_NOBODY => TRUE,			//表示不需要response body
        //		CURLOPT_FOLLOWLOCATION	=> 1
    );

    curl_setopt_array($ch, $options);

    if (!empty($header)) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $result = curl_exec($ch);

    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
        return $result;
    }

    return NULL;
}

function http_post($ch, $url, $data, $header)
{

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => 1,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 150,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_FOLLOWLOCATION => 1        //设置curl支持页面链接跳转

    );

    curl_setopt_array($ch, $options);

    if (!empty($header)) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $output = curl_exec($ch);

    return $output;
}

$ch = curl_init();

$data = json_decode(file_get_contents('password.json'), 1);

$response = http_post($ch, 'https://wuzhi.me/login', $data, [
    'Accept:text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8',
    'Accept-Encoding:gzip, deflate, br',
    'Accept-Language:en-US,en;q=0.8',
    'Cache-Control:no-cache',
    'Connection:keep-alive',
//    'Content-Length:45',
    'Content-Type:application/x-www-form-urlencoded',
    'Host:wuzhi.me',
    'Origin:https://wuzhi.me',
//    'Pragma:no-cache',
    'Referer:https://wuzhi.me/',
    'Upgrade-Insecure-Requests:1',
    'User-Agent:Mozilla/5.0 (Windows NT 6.1; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/59.0.3071.115 Safari/537.36',
]);

file_put_contents('result.txt', $response);
echo $response;