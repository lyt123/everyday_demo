<?php
namespace AutoLoading;
class loading {
    public static function autoload($className)
    {
        //根据PSR-O的第4点 把 \ 转换层（目录风格符） DIRECTORY_SEPARATOR ,
        //便于兼容Linux文件找。Windows 下（/ 和 \）是通用的
        //由于namspace 很规格，所以直接很快就能找到
        $fileName = str_replace('\\', DIRECTORY_SEPARATOR,  DIR . '\\'. $className) . '.php';
        var_dump($className);
        //output : Lib\Name and App\Android\Name
        var_dump($fileName);
        //output : I:\wamp\www\ivan_toper\namespace\Lib\Name.php
        // and I:\wamp\www\ivan_toper\namespace\App\Android\Name.php
        if (is_file($fileName)) {
            require $fileName;
        } else {
            echo $fileName . ' is not exist'; die;
        }
    }
}