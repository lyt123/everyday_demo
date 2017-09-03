<?php
/* User:lyt123; Date:2017/2/7; QQ:1067081452 */

//the following example aims to solve the problem described in demmand.png
$dateStart = new \DateTime();
$dataInterval = \DateInterval::createFromDateString('-1 day');
$datePeriod = new \DatePeriod($dateStart, $dataInterval, 30);

foreach($datePeriod as $date) {
    $file = 'sftp://USER:PASS@rsync.net/'.$date->format('Y-m-d').'.log.bz2';
    if(file_exists($file)){
        $handle = fopen($file, 'rb');
        stream_filter_append($handle, 'bzip2.decompress');
        while(feof($handle) !== true){
            $line = fgets($handle);
            if(strpos($line, 'www.example.com') !== false){
                fwrite(STDOUT, $line);
            }
        }
        fclose($handle);
    }
}