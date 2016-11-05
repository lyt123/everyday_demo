<?php
/* User:lyt123; Date:2016/11/2; QQ:1067081452 */
//$str = 'lkjl';
//var_dump(explode(',', $str));\
$original_data = [
    ['1-4周：3节', '5、7周：2节'],
    ['8-17周：3节', '18周：2节'],
    ['1-3周：3节', '4-5周：2节'],
    ['1-3周：3节', '4-5周：2节'],
    ['1-5、7-18周：3节'],
    ['1、2、4、5-12周：4节']
];
foreach ($original_data as $time_data) {
    foreach ($time_data as $week_section) {
        var_dump($week_section);
        //节数
        $week_section = explode('：', $week_section);
        $classroom_time_data['section_num'] = substr($week_section[1], 0, 1);
        $week_section[0] = substr($week_section[0], 0, -3);

        //周数
        $use_weeks = '';
        if ($weeks = explode('、', $week_section[0])) {
            foreach ($weeks as $week_part) {
                if (strpos($week_part, '-') !== false) {
                    $week_last = explode('-', $week_part);

                    for ($i = $week_last[0]; $i <= $week_last[1]; $i++) {

                        $use_weeks .= $i . ',';
                    }

                } else {
                    $use_weeks .= $week_part . ',';
                }
            }
        } elseif (strpos($week_section[0], '-') !== false) {
            $week_last = explode('-', $week_section[0]);

            for ($i = $week_last[0]; $i <= $week_last[1]; $i++) {

                $use_weeks .= $i . ',';
            }

        } else {
            $use_weeks .= $week_section[0] . ',';
        }
        $classroom_time_data['use_weeks'] = substr($use_weeks, 0, -1);
        var_dump($classroom_time_data);
//    $result = D('ClassroomTime')->updateClassroomTime($classroom_time_where, $classroom_time_data);
//    dd($result);
        unset($weeks);
        unset($week_part);
        unset($week_last);
        unset($use_weeks);
    }
}
