<?php
/* User:lyt123; Date:2017/6/10; QQ:1067081452 */
function httpGet($ch, $url, $header = false) {

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_HEADER => TRUE,	//表示需要response header
        CURLOPT_RETURNTRANSFER => TRUE, //不让拿到的内容直接打印出来
        CURLOPT_TIMEOUT => 300,	//设置超时时间为5分钟
        //	CURLOPT_NOBODY => TRUE,	//表示不需要response body
        //	CURLOPT_FOLLOWLOCATION	=> 1
    );

    curl_setopt_array($ch, $options);

    if(!empty($header)) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $result = curl_exec($ch);

    if (curl_getinfo($ch, CURLINFO_HTTP_CODE) == '200') {
        return $result;
    }

    return NULL;
}


function httpPost($ch, $url, $data, $header) {

    $options = array(
        CURLOPT_URL => $url,
        CURLOPT_POST => 1,
        CURLOPT_RETURNTRANSFER => TRUE,
        CURLOPT_TIMEOUT => 300,
        CURLOPT_POSTFIELDS => http_build_query($data),
        CURLOPT_FOLLOWLOCATION	=> 1	//设置curl支持页面链接跳转

    );

    curl_setopt_array($ch, $options);

    if(!empty($header)) curl_setopt($ch, CURLOPT_HTTPHEADER, $header);

    $output = curl_exec($ch);

    return $output;
}