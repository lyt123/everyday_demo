<?php
/*
 * 1. extract teachers' info from teacher_name.xls into an two-dimension array
 * 2. use teacher's name, crawling teacher's classes from wyu university website
 * 3. put teacher's classes into teacher_name.xls
 */
require_once 'request_info.php';

function getTeacherNameFromExeclAndExtractTeacherClassFromShoolWebsiteHtmlThenInfillExcel()
{
    //include a class for excel handling
    include_once('excel/PHPExcel.php');

    //transfer the excel data into two-dimension array
    $objPHPExcel  = \PHPExcel_IOFactory::load('teacher_name.xls');
    $teacher_info = $objPHPExcel->getActiveSheet()->toArray(null, true, true, false);

    //get teacher classes from website
    unset($teacher_info[0]);

    foreach ($teacher_info as $key => $item) {

        $class_html = getTeacherClassHtmlFromShoolWebsite($item[9]);//$item[9] -> teacher name
        $classes    = extractTeacherClassFromHtml($class_html);
        putTeacherClassIntoExcel($key, $classes, $objPHPExcel);
    }

    //download the final excel
    $excel_name = 'teacher_class_filled.xls';
    promptExcelDownload($objPHPExcel, $excel_name);
}

function promptExcelDownload($objPHPExcel, $excel_name)
{
    header('Content-Type: application/vnd.ms-excel');
    header("Content-Disposition: attachment;filename='{$excel_name}'");
    header('Cache-Control: max-age=0');
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
}

function putTeacherClassIntoExcel($key, $classes, $objPHPExcel)
{
    $string = implode('\n', $classes);
    $objPHPExcel->setActiveSheetIndex(0)
        ->setCellValue('K' . ($key + 1), $string);
    $objPHPExcel->getActiveSheet()->getStyle('K' . ($key + 1))->getAlignment()->setWrapText(true);
}

function extractTeacherClassFromHtml($html)
{
    //在html文件中加上字符编码才不会乱码
    $html = str_replace('<head>', '<head><meta http-equiv="Content-Type" content="text/html;charset=utf-8">', $html);

    //使用php自带的DOMDocument库来处理得到的html
    $doc = new \DOMDocument();
    $doc->loadHTML($html);

    //extract teacher class from the html page by element id
    $i = 0;
    $classes = array();
    while (
    $content = $doc->getElementById('ctl00_ContentPlaceHolder1_ListViewXKH_ctrl' . $i . '_ctimeLabel')
    ) {
        if ($content->textContent)
            $classes[] = $content->textContent;
        $i++;
    }
    return $classes;
}

function getTeacherClassHtmlFromShoolWebsite($teacher_name)
{
    //发送到学校网站的数据
    $post_data = array(
        '__VIEWSTATE' => VALUE_FIRST,
        '__EVENTVALIDATION' => VALUE_SECOND,
        VALUE_THIRD => 'on',
        VALUE_FORTH => $teacher_name,
        VALUE_FIFTH => '提交'
    );

    //调接口
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://202.192.240.54/kkcx/default.aspx');
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post_data));
    curl_setopt($ch, CURLOPT_TIMEOUT, 300);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}

getTeacherNameFromExeclAndExtractTeacherClassFromShoolWebsiteHtmlThenInfillExcel();

