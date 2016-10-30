<?php

class MyMiniSmarty
{
    //模板文件的路径
    var $template_dir = "./templates/";
    //指定一个模板文件被替换后的文件格式com_对应的tpl.php .
    var $complie_dir = "./templates_c/";
    //存放变量值
    var $tpl_vars = array();

    /*模拟两个方法*/
    function assign($tpl_var, $val = null)
    {
        if ($tpl_var != '') {
            $this->tpl_vars[$tpl_var] = $val;
        }
    }

    function display($tpl_file)
    {
        //读取这个模板文件->替换可以运行php(编译后文件)!!!
        $tpl_file_path = $this->template_dir . $tpl_file;
        $complie_file_path = $this->complie_dir . "com_" . $tpl_file . ".php";

        //判断文件存在否.
        if (!file_exists($tpl_file_path)) return false;

        //编译后文件不存在，或者模板被修改时才if(true)
        if (!file_exists($complie_file_path) || filemtime($tpl_file_path) > filemtime($complie_file_path)) {

            $fpl_file_con = file_get_contents($tpl_file_path);

            //正则可以封装成函数，以便smarty获取时的书写方式变化
            $pattern = array(
                '/\{\s*\$([a-zA-Z_][a-zA-Z0-9_]*)\s*\}/i'
            );
            $replace = array(
                '<?php echo $this->tpl_vars["${1}"] ?>'
            );
            $new_str = preg_replace($pattern, $replace, $fpl_file_con);

            file_put_contents($complie_file_path, $new_str);
        }
        //引入编译后的文件
        include $complie_file_path;
    }
}