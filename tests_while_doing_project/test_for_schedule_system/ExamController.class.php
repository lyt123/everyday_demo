<?php
/* User:lyt123; Date:2016/11/4; QQ:1067081452 */
namespace Admin\Controller;

class ExamController extends CourseExcelImportController{

    public function outputOfficialCourseOfOneSemester()
    {
        $model = D('SelectBook');

        include_once __PUBLIC__ . '/plugins/excel/PHPexcel.php';
        $objPHPExcel = new \PHPExcel();

        $model->setOfficialCourseOfOneSemesterExcelTitle($objPHPExcel);

        $course_data = D('Course')
            ->table('course co, class cl')
            ->field('co.*')
            ->where('co.class_id = cl.id and cl.type <> 1 and cl.type <> 2')
            ->order('class_id')
            ->select();
        $course_data = $model->processData($course_data);

        $excel_data = array();
        $i = 0;
        $j = 0;
        $class_ids = array();
        foreach ($course_data as $item) {
            //序号要跟随班级递增
            if (in_array($item['class_id'], $class_ids)) {
                $excel_data[$i][0] = $j;
            } else {
                $excel_data[$i][0] = ++$j;
                $class_ids[] = $item['class_id'];
            }
            $excel_data[$i][1] = $item['academy'];
            $excel_data[$i][2] = $item['class_name'];
            $excel_data[$i][3] = $item['student_sum'];
            $excel_data[$i][4] = $item['code'];
            $excel_data[$i][5] = $item['name'];
            $excel_data[$i][6] = $item['examine_way'];
            $excel_data[$i][7] = $item['time_total'];
            $excel_data[$i][8] = $item['time_theory'];
            $excel_data[$i][9] = $item['time_practice'];
            $excel_data[$i][10] = $item['teacher'];
            $excel_data[$i][11] = '';
            $excel_data[$i][12] = '';
            $excel_data[$i][13] = $item['comment'];
            $i++;
        }

        automaticWrapText($objPHPExcel, count($excel_data) + 5);
        $objPHPExcel->getActiveSheet()->fromArray($excel_data, NULL, 'A4');
        promptExcelDownload($objPHPExcel, '学期课程表.xls');
    }
}
