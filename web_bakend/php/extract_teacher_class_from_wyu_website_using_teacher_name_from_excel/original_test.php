<?php
function getTeacherNameFromExeclAndExtractTeacherClassFromShoolWebsiteHtmlThenInfillExcel()
{
    include_once('excel/PHPExcel.php');
    $objPHPExcel = \PHPExcel_IOFactory::load('teacher_name.xls');
    $teacher_no_assign = getTeacherNameFromExeclAndExtractTeacherClassFromShoolWebsiteHtml($objPHPExcel);

    //put teachers' classes into appropriate excel cell
    foreach ($teacher_no_assign as $key => $item) {
        $string = implode('\n', $item);
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('K' . ($key + 2), $string);
        $objPHPExcel->getActiveSheet()->getStyle('K' . ($key + 2))->getAlignment()->setWrapText(true);
    }

    //prompt downloading the excel named teacher_class_filled.xls
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="teacher_class_filled.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
}

function getTeacherNameFromExeclAndExtractTeacherClassFromShoolWebsiteHtml($objPHPExcel)
{
    //transfer the excel day into two-dimension array
    $data = $objPHPExcel->getActiveSheet()->toArray(null, true, true, false);
    unset($data[0]);

    //teacher data begins at the second row
    $teacher_no_assign = array();//教师不能上课的时间段
    foreach ($data as $item) {
        //teacher class into in the ninth element of the array
        $teacher_no_assign[] = extractTeacherClassFromShoolWebsiteHtml($item[9]);
    }
    return $teacher_no_assign;
}

function extractTeacherClassFromShoolWebsiteHtml($teacher)
{
    $html = getTeacherClassFromSchoolWebsite($teacher);

    //在html文件中加上字符编码才不会乱码
    $html = str_replace('<head>', '<head><meta http-equiv="Content-Type" content="text/html;charset=utf-8">', $html);

    //使用php自带的DOMDocument库来处理得到的html
    $doc = new \DOMDocument();
    $doc->loadHTML($html);

    //extract teacher class from the html page by element id
    $i = 0;
    $data = array();
    while (
    $content = $doc->getElementById('ctl00_ContentPlaceHolder1_ListViewXKH_ctrl' . $i . '_ctimeLabel')
    ) {
        if ($content->textContent)
            $data[] = $content->textContent;
        $i++;
    }
    return $data;
}

function getTeacherClassFromSchoolWebsite($teacher)
{
    //发送到学校网站的数据
    $post_data = array(
        '__VIEWSTATE' => VALUE_FIRST,
        '__EVENTVALIDATION' => VALUE_SECOND,
        VALUE_THIRD => 'on',
        VALUE_FORTH => $teacher,
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

//call the function bellow, teacher_class_filled.xls will be generated in current folder
getTeacherNameFromExeclAndExtractTeacherClassFromShoolWebsiteHtmlThenInfillExcel();