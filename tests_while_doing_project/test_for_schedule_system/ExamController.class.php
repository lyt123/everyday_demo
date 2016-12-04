<?php
/* User:lyt123; Date:2016/11/4; QQ:1067081452 */
namespace Admin\Controller;

class ExamController extends CourseExcelImportController{
    public function dd()
    {
        foreach ($search_data as $item) {
            $course_data = D('Course')->getData(array('code' => $item['code'], 'class_id' => $item['class_id']));
            $data[$j]['id'] = $item['id'];
            $data[$j]['open_class_academy'] = current(D('SelectBook')->getData(array('class_name' => current(D('Class')->getData(array('id' => $item['class_id']), array('name'))), 'name' => $course_data['name']), array('open_class_academy')));
            $data[$j]['have_class_academy'] = current(D('SelectBook')->getData(array('class_name' => current(D('Class')->getData(array('id' => $item['class_id']), array('name'))), 'name' => $course_data['name']), array('have_class_academy')));
            $data[$j]['class_name'] = current(D('Class')->getData(array('id' => $item['class_id']), array('name')));
            $data[$j]['student_sum'] = current(D('Class')->getData(array('id' => $item['class_id']), array('student_sum')));
            $data[$j]['code'] = $item['code'];
            $data[$j]['name'] = $course_data['name'];
            $data[$j]['examine_way'] = transferExamineWay(1);
            $data[$j]['time_total'] = $course_data['time_total'];
            $data[$j]['teacher_name'] = current(D('Teacher')->getData(array('id' => $course_data['teacher_id']), array('name')));
            $data[$j]['time'] = $this->transferPeriodToDate($item['period'], $exam_week);
            if ($item['classroom_time_id']) {
                $data[$j]['classroom'] = '马兰芳教学楼' . current(D('ClassroomTime')->getData(array('id' => $item['classroom_time_id']), array('number')));
            } elseif ($item['other_classroom']) {
                $data[$j]['classroom'] = $item['other_classroom'];
            }else {
                $data[$j]['classroom'] = '';
            }
            $data[$j]['monitor_teacher_name'] = $item['monitor_teacher_name'] ? $item['monitor_teacher_name'] : '';
            $j++;
        }
    }
}
