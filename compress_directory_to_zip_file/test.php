<?php
/* User:lyt123; Date:2016/12/14; QQ:1067081452 */
function list_dir($dir)
{
    $result = array();
    if (is_dir($dir)) {
        $file_dir = scandir($dir);
        foreach ($file_dir as $file) {
            if ($file == '.' || $file == '..') {
                continue;
            } elseif (is_dir($dir . $file)) {
                $result = array_merge($result, list_dir($dir . $file . '/'));
            } else {
                array_push($result, $dir . $file);
            }
        }
    }
    return $result;
}

function compress_directory_to_zip_file($dir, $filename)
{

    $datalist = list_dir($dir);

    $zip = new ZipArchive();//使用本类，linux需开启zlib，windows需取消php_zip.dll前的注释
    if ($zip->open($filename, ZIPARCHIVE::CREATE)!==TRUE) {
        exit('无法打开文件，或者文件创建失败');
    }
    foreach( $datalist as $val){
        if(file_exists($val)){
            //这里我加了urldecode()函数，将字符编码改正过来
            $zip->addFile( $val, urldecode(basename($val)));//第二个参数是放在压缩包中的文件名称，如果文件可能会有重复，就需要注意一下
        }
    }
    $zip->close();//关闭
}

function zip_file_prompt_download($file_path, $file_name)
{
    header("Cache-Control: public");
    header("Content-Description: File Transfer");
    header('Content-disposition: attachment; filename=' . $file_name.'.zip'); //文件名
    header("Content-Type: application/zip"); //zip格式的
    header("Content-Transfer-Encoding: binary"); //告诉浏览器，这是二进制文件
    header('Content-Length: ' . filesize($file_path)); //告诉浏览器，文件大小
    @readfile($file_path);
}

//call function : attention->if you download the zip file the second time, you may need to first delete the test.zip file generate in te first call.
compress_directory_to_zip_file('./files_to_compress/', './files_to_compress/test.zip');
zip_file_prompt_download('./files_to_compress/test.zip', 'test');