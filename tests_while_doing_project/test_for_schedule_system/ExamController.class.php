<?php
/* User:lyt123; Date:2016/11/4; QQ:1067081452 */
namespace Admin\Controller;

class ExamController extends CourseExcelImportController
{
    public function clearExamArrangeData()
    {
        $post_data = $this->reqAdmin()->reqPost(array('week'));

        $course_model = D('Course');
        $course_model->startTrans();

        $delete_exam_result = '';
        $delete_course_result = '';

        if ($post_data['week'] == 13) {
            $delete_exam_result = D('Exam')->where(array('week' => 13))->delete();
            $delete_course_result = D('Course')->where(array('exam_status' => array('in', [5, 6])))->save(array('exam_status' => 4));
        }
        if ($post_data['week'] == 19) {
            $delete_exam_result = D('Exam')->where(array('week' => 19))->delete();
            $delete_course_result = D('Course')->where(array('exam_status' => array('in', [2, 3])))->save(array('exam_status' => 1));
        }
        D('ExamInNineteenthWeek')->where(array('week' => $post_data['week']))->delete();

        if (
            $delete_exam_result &&
            $delete_course_result !== false
        ) {
            $course_model->commit();
            $this->ajaxReturn(ajax_ok(array(), '清空数据成功'));
        }
        $course_model->rollback();
        $course_model->commit();
        $this->ajaxReturn(ajax_error('清空数据失败'));
    }

    /**
     * Des :导入已考试课程表
     * Auth:lyt123
     */
    public function importAlreadyExamCourseExcel()
    {
        $this->reqAdmin();
        $course_data = loadExcel('already_exam-', 'excel_files/exam/already_exam/', 1);
        $course_model = D('Course');
        $course_model->startTrans();

        foreach ($course_data as $item) {
            $class_id = current(D('Class')->getData(array('name' => $item[0]), array('id')));
            $course_id = current($course_model->getData(array('class_id' => $class_id, 'name' => $item[1]), array('id')));
            $result = $course_model->update($course_id, array('exam_status' => 7));
            $this->checkResult($result, $course_model);
        }

        $course_model->commit();
        $this->ajaxReturn(ajax_ok());
    }

    /**
     * Des :十九周安排考试，将下面为公共课和为其他课程排考试结合
     * Auth:lyt123
     */
    public function automaticArrangeExamInNineteenthWeek()
    {
        $post_data = $this->reqAdmin()->reqPost(array('week'));

        $course_model = D('Course');

        if ($post_data['week'] == 13) {
            $this->automaticArrangeExamForCourseInThirteenthWeek();
        }
        if ($post_data['week'] == 19) {
            $this->automaticArrangeExamForOtherCourseInNineteenthWeek($course_model);
            $this->automaticArrangeExamForPublicCourseInNineteenthWeek($course_model);
        }

        $course_model->commit();
        $this->ajaxReturn(ajax_ok());
    }

    public function automaticArrangeExamForPublicCourseInNineteenthWeek($course_model)
    {
//        $course_model = D('Course');
//        $course_model->startTrans();

        $public_courses = D('PublicCourse')->getData(null, null, true);
        //        dump($public_courses);
        $previous_period = array();
        //将非村官班的考试可排时间跟节假日错开

        $available_period = array_diff(array(1, 2, 3, 4, 5, 8, 9, 10, 11), D('Holiday')->getPeriods(current(D('Holiday')->getData(array('week' => 19), array('weekday')))));

        foreach ($public_courses as $one_type_public_course) {

            $public_course_teachers = array();
            $public_course_classes = array();
            $teacher_existing_class_period = array();
            $teacher_other_course_exam_period = array();
            $class_other_course_period = array();

            $one_type_public_courses = D('Course')->getData(array('name' => $one_type_public_course['name'], 'academy_id' => array('NEQ', 0), 'examine_way' => 1), null, true);
            foreach ($one_type_public_courses as $single_course) {
                $public_course_teachers[] = $single_course['teacher_id'];
                $public_course_classes[] = $single_course['combine_status'];
            }
            $public_course_teachers = array_values(array_unique($public_course_teachers));
            $public_course_classes = array_values(array_unique($public_course_classes));

            //将几门公共课的考试时间隔开
            $origin_periods = array_diff($available_period, $previous_period);
            foreach ($public_course_teachers as $single_teacher) {
                //排除教师普教上课时间
                if ($result = self::filterTeacherExistingClass($single_teacher))
                    $teacher_existing_class_period = array_merge($teacher_existing_class_period, $result);

                //排除教师其他课程考试时间
                if ($result = self::filterTeacherOtherCourseExam($single_teacher))
                    $teacher_other_course_exam_period = array_merge($teacher_other_course_exam_period, $result);
            }

            foreach ($public_course_classes as $single_combine_classes) {
                //排除合班其他课程考试时间
                if ($result = self::filterClassOtherCourseExam($single_combine_classes))
                    $class_other_course_period = array_merge($class_other_course_period, $result);
                foreach (explode(',', $single_combine_classes) as $combine_class) {
                    $course_id = current($course_model->getData(array('class_id' => $combine_class, 'code' => $one_type_public_courses[0]['code']), array('id')));
                    $course_model->update($course_id, array('exam_status' => 2));
                }
            }
            //剩余的period
//            dump($teacher_existing_class_period);
//            dump($teacher_other_course_exam_period);
//            dump($class_other_course_period);
            $remain_period = array_diff($origin_periods, $teacher_existing_class_period, $teacher_other_course_exam_period, $class_other_course_period);

            //下面rand()，要保证数组的键是连续的
            $remain_period = array_values($remain_period);
//            dump($remain_period);

            $period_sum = count($remain_period);
            $rand = rand(0, $period_sum - 1);
            $remain_period = $remain_period[$rand];
//                dd($remain_period);

            $result = D('Exam')->addOne(array('code' => $one_type_public_courses[0]['code'], 'week' => 19, 'period' => $remain_period));

            $this->checkResult($result, $course_model);
            $previous_period[] = $remain_period;
        }

//        $course_model->commit();
        return ajax_ok();
    }

    public function automaticArrangeExamForOtherCourseInNineteenthWeek($course_model)
    {
        //获取未考试课程信息(exam_status == 1)
//        $course_model = D('Course');
//        $course_model->startTrans();
//$time = time();

        while ($course_info = $course_model->getData(array('exam_status' => 1, 'examine_way' => 1), array('id', 'teacher_id', 'class_id', 'combine_status', 'name', 'code'))) {
//if((time()-$time)>10)break;

            if (preg_match('/[C]/', current(D('Class')->getData(array('id' => $course_info['class_id']), array('name')))))
                $origin_periods = array_diff(array(6, 7), D('Holiday')->getPeriods(current(D('Holiday')->getData(array('week' => 19), array('weekday')))));//非村官班的班级里有'C'
            else
                $origin_periods = array_diff(array(1, 2, 3, 4, 5, 8, 9, 10, 11), D('Holiday')->getPeriods(current(D('Holiday')->getData(array('week' => 19), array('weekday')))));
//dump($origin_periods);
            //排除教师普教上课时间
            $teacher_existing_class_period = self::filterTeacherExistingClass($course_info['teacher_id']);

            //排除教师其他课程考试时间
            $teacher_other_course_exam_period = self::filterTeacherOtherCourseExam($course_info['teacher_id']);

//            dump('teacher_other_course_exam_period:');
//            dump($teacher_other_course_exam_period);

            //排除班级（或合班）其他课程考试时间
            if ($course_info['combine_status']) {
                $class_other_course_period = self::filterClassOtherCourseExam($course_info['combine_status']);
            } else {
                $class_other_course_period = self::filterClassOtherCourseExam($course_info['class_id']);
            }

//            dump('class_other_course_period:');
//            dump($class_other_course_period);

            //剩余的period
            $remain_period = array_values(array_diff($origin_periods, $teacher_existing_class_period, $teacher_other_course_exam_period, $class_other_course_period));

//            dump($remain_period);
            //循环剩余的period，寻找合适的教室
            if (count($remain_period) == 0) {
                $course_model->update($course_info['id'], array('exam_status' => 3));
            } else {
                //count($remain_period) >= 1
                //随机选择一个时间
                $period_sum = count($remain_period);
                $rand = rand(0, $period_sum - 1);
                $remain_period = $remain_period[$rand];
//                dd($remain_period);
                if ($course_info['combine_status']) {
                    D('Exam')->addOne(array('code' => $course_info['code'], 'week' => 19, 'period' => $remain_period));
                    foreach (explode(',', $course_info['combine_status']) as $combine_class) {
                        $course_id = current($course_model->getData(array('class_id' => $combine_class, 'code' => $course_info['code']), array('id')));
                        $course_model->update($course_id, array('exam_status' => 2));
                    }
                } else {
                    D('Exam')->addOne(array('code' => $course_info['code'], 'period' => $remain_period, 'week' => 19));
                    $course_model->update($course_info['id'], array('exam_status' => 2));
                }
            }
//            dd();
        }
//        $course_model->commit();
        return ajax_ok();
    }

    /**
     * Des :导入需要在十三周安排考试的课程表
     * Auth:lyt123
     */
    public function importExamInThirteenthWeekCourseExcel()
    {
        $course_data = loadExcel('already_exam-', 'excel_files/exam/exam_in_thirteenth_week_course/', 2);
        $course_model = D('Course');
        $course_model->startTrans();
//dd($course_data);
        foreach ($course_data as $item) {
            $class_id = current(D('Class')->getData(array('name' => $item[0]), array('id')));
            $course_id = current($course_model->getData(array('class_id' => $class_id, 'name' => $item[1]), array('id')));
            $result = $course_model->update($course_id, array('exam_status' => 4));
            $this->checkResult($result, $course_model);
        }

        $course_model->commit();
        $this->ajaxReturn(ajax_ok());
    }

    public function automaticArrangeExamForCourseInThirteenthWeek()
    {
        $course_model = D('Course');
        $course_model->startTrans();

        //exam_status = 3 表示课程要在十三周进行考试安排
        while ($course_info = $course_model->getData(array('exam_status' => 4, 'examine_way' => 1), array('id', 'teacher_id', 'class_id', 'combine_status', 'name', 'code'))) {

            //判断是否村官班课程，相应的考试时间安排也不一样
            if (preg_match('/[C]/', current(D('Class')->getData(array('id' => $course_info['class_id']), array('name')))))
                $origin_periods = array_diff(array(6, 7), D('Holiday')->getPeriods(current(D('Holiday')->getData(array('week' => 13), array('weekday')))));//非村官班的班级里有'C'
            else
                $origin_periods = array_diff(array(1, 2, 3, 4, 5, 8, 9, 10, 11), D('Holiday')->getPeriods(current(D('Holiday')->getData(array('week' => 13), array('weekday')))));
//            dd($origin_periods);

            //排除教师普教上课时间
            $teacher_existing_class_period = self::filterTeacherExistingClass($course_info['teacher_id'], 13);

            dump($teacher_existing_class_period);

            //排除教师其他课程考试时间
            $teacher_other_course_exam_period = self::filterTeacherOtherCourseExam($course_info['teacher_id'], 13, 4);

            //排除教师在成教上课时间
            $teacher_course_period = self::filterTeacherCourseInthirteenthWeek($course_info['teacher_id']);
            dump('teacher_course_period:');
            dump($teacher_course_period);


            dump('teacher_other_course_exam_period:');
            dump($teacher_other_course_exam_period);

            //排除班级（或合班）其他课程考试时间
            if ($course_info['combine_status']) {
                $class_other_course_period = self::filterClassOtherCourseExam($course_info['combine_status'], 13, 4);
                $class_course_period = self::filterClassCourseInthirteenthWeek($course_info['combine_status']);
            } else {
                $class_other_course_period = self::filterClassOtherCourseExam($course_info['class_id'], 13, 4);
                $class_course_period = self::filterClassCourseInthirteenthWeek($course_info['class_id']);
            }


            dump('class_other_course_period:');
            dump($class_other_course_period);


            //排除班级（或合班）在成教上课时间
            dump('class_course_period:');
            dump($class_course_period);

            //剩余的period
            $remain_period = array_values(array_diff($origin_periods, $teacher_existing_class_period, $teacher_other_course_exam_period, $class_other_course_period));
            dump($remain_period);
            //循环剩余的period，寻找合适的教室
            if (count($remain_period) == 0) {
                $course_model->update($course_info['id'], array('exam_status' => 6));
            } else {
                //count($remain_period) >= 1
                //随机选择一个时间
                $period_sum = count($remain_period);
                $rand = rand(0, $period_sum - 1);
                $remain_period = $remain_period[$rand];
//                dd($remain_period);
                if ($course_info['combine_status']) {
                    D('Exam')->addOne(array('code' => $course_info['code'], 'week' => 13, 'period' => $remain_period));
                    foreach (explode(',', $course_info['combine_status']) as $combine_class) {
                        $course_id = current($course_model->getData(array('class_id' => $combine_class, 'code' => $course_info['code']), array('id')));
                        $course_model->update($course_id, array('exam_status' => 5));
                    }
                } else {
                    D('Exam')->addOne(array('code' => $course_info['code'], 'period' => $remain_period, 'week' => 13));
                    $course_model->update($course_info['id'], array('exam_status' => 5));
                }
            }
        }
        $course_model->commit();
        $this->ajaxReturn(ajax_ok());
    }

    /**
     * Des :十三周安排考试需另外考虑的
     * Auth:lyt123
     */
    public function filterTeacherCourseInthirteenthWeek($teacher_id)
    {
        $courses = D('Course')->getData(array('teacher_id' => $teacher_id), array('week_section_ids'), true);
//        dump($courses);
        $period = array();
        foreach ($courses as $course) {
            $week_section_ids = explode(',', $course['week_section_ids']);
//            dump($week_section_ids);
            foreach ($week_section_ids as $week_section_id) {
                $week_section_data = D('WeekSection')->getData(array('id' => $week_section_id));
                $use_weeks = explode(',', $week_section_data['use_weeks']);
                if (in_array(12, $use_weeks)) {
                    $period[] = current(D('ClassroomTime')->getData(array('id' => $week_section_data['classroom_time_id']), array('period')));
                }
            }
        }
        return $period;
    }

    public function filterClassCourseInthirteenthWeek($class_ids)
    {
        $class_ids = explode(',', $class_ids);

        $period = array();
        foreach ($class_ids as $class_id) {
            $courses = D('Course')->getData(array('class_id' => $class_id), array('week_section_ids'), true);
            foreach ($courses as $course) {
                $week_section_ids = explode(',', $course['week_section_ids']);
//                dump($week_section_ids);
                foreach ($week_section_ids as $week_section_id) {
                    $week_section_data = D('WeekSection')->getData(array('id' => $week_section_id));
                    $use_weeks = explode(',', $week_section_data['use_weeks']);
                    if (in_array(12, $use_weeks)) {
                        $period[] = current(D('ClassroomTime')->getData(array('id' => $week_section_data['classroom_time_id']), array('period')));
                    }
                }
            }
        }
        return $period;
    }

    /**
     * Des :各种情况不冲突
     * Auth:lyt123
     */
    public
    function filterTeacherExistingClass($teacher_id, $exam_week = 19)
    {
        $existing_class = current(D('TeacherExistingClass')->getData(array('teacher_id' => $teacher_id), array('existing_class')));

        $existing_class_period = array();

        //如果没有上课信息，直接返回空
        if (!$existing_class)
            return $existing_class_period;

        if (strpos($existing_class, '\n') !== false)
            $classes_time = explode('\n', $existing_class);
        else
            $classes_time[] = $existing_class;

        foreach ($classes_time as $class_time) {
            if (substr($class_time, -6, 6) == '晚上') {
                $week_combine = '';
                if (strpos($class_time, ',') !== false) {
                    $different_weeks = explode(',', $class_time);
                    foreach ($different_weeks as $separate_week) {
                        $weeks = get_between($separate_week, '第', '周');

                        if (strpos($weeks, '-')) {
                            $weeks = explode('-', $weeks);
                            for ($i = $weeks[0]; $i <= $weeks[1]; $i++) {

                                $week_combine .= $i . ',';
                            }
                        } else {
                            $week_combine .= $weeks . ',';
                        }
                    }
                } elseif (strpos($class_time, '-')) {
                    $weeks = get_between($class_time, '第', '周');
                    $weeks = explode('-', $weeks);
                    for ($i = $weeks[0]; $i <= $weeks[1]; $i++) {

                        $week_combine .= $i . ',';
                    }
                } else {
                    $weeks = get_between($class_time, '第', '周');
                    $week_combine .= $weeks;
                }
//                dump($week_combine);
                //解决‘第19周星期三晚上’
                if (strpos($week_combine, ',') !== false) {
                    $weeks = explode(',', substr($week_combine, 0, -1));
                } else $weeks = array($week_combine);

                if (in_array($exam_week, $weeks)) {
                    $weekday = substr($class_time, strlen($class_time) - 9, 3);

                    switch ($weekday) {
                        case '一':
                            $existing_class_period[] = 1;
                            break;
                        case '二':
                            $existing_class_period[] = 2;
                            break;
                        case '三':
                            $existing_class_period[] = 3;
                            break;
                        case '四':
                            $existing_class_period[] = 4;
                            break;
                        case '五':
                            $existing_class_period[] = 5;
                            break;
                    }
                }
            }
        }
//        dd($existing_class_period);
        return $existing_class_period;
    }

    public
    function filterTeacherOtherCourseExam($teacher_id, $exam_week = 19, $exam_status = 2)
    {
        //教师其他有考试的课程的考试时间
        $classes = D('Course')->getData(array('teacher_id' => $teacher_id, 'exam_status' => $exam_status), array('code'), true);

        //考试时间地点
        $period = array();
        if ($classes) {
            foreach ($classes as $class) {
                $period[] = current(D('Exam')->getData(array('code' => $class['code'], 'week' => $exam_week), array('period')));
            }
        }

        return $period;
    }

    public
    function filterClassOtherCourseExam($class, $exam_week = 19, $exam_status = 2)
    {
        $period = array();
        if (strpos($class, ',') !== false) {
            $classes = explode(',', $class);
        } else {
            $classes[] = $class;
        }
//        dump($classes);
        foreach ($classes as $one_class) {
            $class_courses = D('Course')->getData(array('class_id' => $one_class, 'exam_status' => $exam_status), array('code'), true);

            if ($class_courses) {
                foreach ($class_courses as $class_course) {
                    $period[] = current(D('Exam')->getData(array('code' => $class_course['code'], 'week' => $exam_week), array('period')));
                }
            }
        }
        return $period;
    }


    /**
     * Des :导出已有考试时间的考试安排表
     * Auth:lyt123
     */
    public function outputExamExcel()
    {
        $model = D('Exam');
        $data = $model->getData(array(), array('code', 'period'), true);
//        dump($data);
        $excel_data = array();
        $j = 0;
        foreach ($data as $item) {
            $course_data = D('Course')->getData(array('code' => $item['code']), array(), true, 'teacher_id, class_id');
//            dd($course_data);
//dump($item);continue;
            $sum = count($course_data);
            for ($i = 0; $i < $sum; $i++) {
                //填坑，暂时先这样写，以后扩展了再来修改
                $excel_data[$j][0] = current(D('SelectBook')->getData(array('class_name' => current(D('Class')->getData(array('id' => $course_data[$i]['class_id']), array('name'))), 'name' => $course_data[$i]['name']), array('open_class_academy')));
                $excel_data[$j][1] = current(D('SelectBook')->getData(array('class_name' => current(D('Class')->getData(array('id' => $course_data[$i]['class_id']), array('name'))), 'name' => $course_data[$i]['name']), array('have_class_academy')));
                $excel_data[$j][2] = current(D('Class')->getData(array('id' => $course_data[$i]['class_id']), array('name')));
                $excel_data[$j][3] = current(D('Class')->getData(array('id' => $course_data[$i]['class_id']), array('student_sum')));
                if (preg_match('/[a-zA-Z]/', $course_data[$i]['code']))
                    $excel_data[$j][4] = $course_data[$i]['code'];
                else
                    $excel_data[$j][4] = current(D('SelectBook')->getData(array('class_name' => current(D('Class')->getData(array('id' => $course_data[$i]['class_id']), array('name'))), 'name' => $course_data[$i]['name']), array('code')));
                $excel_data[$j][5] = $course_data[$i]['name'];
                $excel_data[$j][6] = transferExamineWay($course_data[$i]['examine_way']);
                $excel_data[$j][7] = $course_data[$i]['time_total'];
                $excel_data[$j][8] = current(D('Teacher')->getData(array('id' => $course_data[$i]['teacher_id']), array('name')));
                $excel_data[$j][9] = $model->transferPeriodToDate($item['period']);
                $j++;
            }
        }

//                dd($excel_data);
        include_once __PUBLIC__ . '/plugins/excel/PHPexcel.php';
        $objPHPExcel = new \PHPExcel();
        $model->setWorkExamExcelTitle($objPHPExcel);
        $model->setWorkExamExcelCellWidth($objPHPExcel);
        $objPHPExcel->getActiveSheet()->fromArray($excel_data, NULL, 'A3');
        automaticWrapText($objPHPExcel, count($excel_data) + 5);
        promptExcelDownload($objPHPExcel, 'test.xls');
    }

    /**
     * Des :导入填有考试地点和已修改的考试时间的考试安排表
     * Auth:lyt123
     */
    public function importExamInNineteenthWeekExcel()
    {
        $exam_data = loadExcel('exam_in_nineteenth_week-', 'excel_files/exam_in_nineteenth_week/', 2);
        $model = D('Exam');
        $model->startTrans();
//dd($exam_data);
        foreach ($exam_data as $key => $item) {
            //如果表格最后有空行，则返回成功
            if (!$item[0]) {
                $model->commit();
                $this->ajaxReturn(ajax_ok(array(), '已读取到最后一行，导入成功'));
            }

            $course_data['class_id'] = current(D('Class')->getData(array('name' => $item[2]), array('id')));
            $course_data['code'] = $item[4];
            $data = array();
            $data['course_id'] = current(D('Course')->getData($course_data, array('id')));
            $data['time'] = $item[9];
            $data['place'] = $item[10];

            $this->checkResult(D('ExamInNineteenthWeek')->addOne($data), $model);
        }
        $model->commit();
        $this->ajaxReturn(ajax_ok());
    }

    /**
     * Des :更新监考教师
     * Auth:lyt123
     */
    public function updateMonitorTeacher()
    {
        $post_data = $this->reqAdminAcademy()->reqPost(array('exam_id', 'teacher_name'));
        $data['monitor_teacher_id'] = D('Teacher')->transferMultipleTeacherNameToTeacherIds($post_data['teacher_name']);
        D('ExamInNineteenthWeek')->update($post_data['exam_id'], $data);
    }

    /**
     * Des :查询考试信息
     * Auth:lyt123
     */
    public function showExam()
    {
        $data = $this->reqPost(array(), array('academy_id', 'teacher_name', 'class_name', 'code'));
        $exam_data = $this->getExamData($data);
        $this->ajaxReturn(ajax_ok($exam_data));
    }

    /**
     * Des :获取考试信息，查询考试和导出考试可公用
     * Auth:lyt123
     */
    public function getExamData($data)
    {
        $exam_data = array();
        if ($data['academy_id']) {
            //获取学院名称
            $academy_name = current(D('Academy')->getData(array('id' => $data['academy_id']), array('name')));
            //获取开课信息
            $select_book_data = D('SelectBook')->getData(array('open_class_academy' => $academy_name), array('code', 'class_name'), true);
            //获取课程及考试信息
            foreach ($select_book_data as $item) {
                $item['class_id'] = current(D('Class')->getData(array('name' => $item['class_name']), array('id')));
                $course_id = current(D('Course')->getData($item, array('id')));
                if ($result = D('ExamInNineteenthWeek')->getData(array('course_id' => $course_id))) {
                    $exam_data[] = $result;
                }
            }
        }
        if ($data['teacher_name']) {
            $teacher_id = current(D('Teacher')->getData(array('name' => $data['teacher_name']), array('id')));
            $course_ids = D('Course')->getData(array('teacher_id' => $teacher_id), array('id'), true);
            foreach ($course_ids as $course) {
                if ($result = D('ExamInNineteenthWeek')->getData(array('course_id' => $course['id'])))
                    $exam_data[] = $result;
            }
        }
        if ($data['class_name']) {
            $class_id = current(D('Class')->getData(array('name' => $data['class_name']), array('id')));
            $course_ids = D('Course')->getData(array('class_id' => $class_id), array('id'), true);
            foreach ($course_ids as $course) {
                if ($result = D('ExamInNineteenthWeek')->getData(array('course_id' => $course['id'])))
                    $exam_data[] = $result;
            }
        }
        if ($data['code']) {
            $course_ids = D('Course')->getData(array('code' => $data['code']), array('id'), true);
            foreach ($course_ids as $course) {
                if ($result = D('ExamInNineteenthWeek')->getData(array('course_id' => $course['id'])))
                    $exam_data[] = $result;
            }
        }
//dd($exam_data);
        foreach ($exam_data as &$item) {
            $course_data = D('Course')->getData(array('id' => $item['course_id']), array('name', 'code', 'examine_way', 'time_total', 'class_id', 'teacher_id'));
            $teacher_name = current(D('Teacher')->getData(array('id' => $course_data['teacher_id']), array('name')));
            $item['teacher_name'] = D('Teacher')->getMultipleTeacherCourse($teacher_name, $course_data['teacher_id']);
            $item['monitor_teacher_name'] = D('Teacher')->transferMultipleTeacherIdToTeacherNames($item['monitor_teacher_id']);
            $item['class_name'] = current(D('Class')->getData(array('id' => $course_data['class_id']), array('name')));
            $item['name'] = $course_data['name'];
            $item['code'] = $course_data['code'];
            $item['examine_way'] = transferExamineWay($course_data['examine_way']);
            $item['student_sum'] = current(D('Class')->getData(array('id' => $course_data['class_id']), array('student_sum')));
            $item['time_total'] = $course_data['time_total'];

            $academy_data = D('SelectBook')->getData(array('name' => $course_data['name'], 'code' => $course_data['code']), array('open_class_academy', 'have_class_academy'));
            $item['open_class_academy'] = $academy_data['open_class_academy'];
            $item['have_class_academy'] = $academy_data['have_class_academy'];
        }
        return $exam_data;
    }

    /**
     * Des :导出完整的考试安排表
     * Auth:lyt123
     */
    public function ouputExam()
    {
//        $data = $this->reqPost(array(), array('academy_id', 'teacher_name', 'class_name', 'code'));
        $data['academy_id'] = 1;
        $model = D('Exam');
        $exam_data = $this->getExamData($data);
        $excel_data = array();
        foreach ($exam_data as $key => $item) {
            $excel_data[$key][0] = $item['open_class_academy'];
            $excel_data[$key][1] = $item['have_class_academy'];
            $excel_data[$key][2] = $item['class_name'];
            $excel_data[$key][3] = $item['student_sum'];
            $excel_data[$key][4] = $item['code'];
            $excel_data[$key][5] = $item['name'];
            $excel_data[$key][6] = $item['examine_way'];
            $excel_data[$key][7] = $item['time_total'];
            $excel_data[$key][8] = $item['teacher_name'];
            $excel_data[$key][9] = $item['time'];
            $excel_data[$key][10] = $item['place'];
            $excel_data[$key][11] = $item['monitor_teacher_name'];
        }
        include_once __PUBLIC__ . '/plugins/excel/PHPexcel.php';
        $objPHPExcel = new \PHPExcel();
        $model->setWorkExamExcelTitle($objPHPExcel);
        $model->setWorkExamExcelCellWidth($objPHPExcel);
        $objPHPExcel->getActiveSheet()->fromArray($excel_data, NULL, 'A2');
        automaticWrapText($objPHPExcel, count($excel_data) + 5);
        promptExcelDownload($objPHPExcel, 'test.xls');
    }
}
