<?php
/* User:lyt123; Date:2016/11/3; QQ:1067081452 */
if ($classroom_time) {

    //确定period，周一晚-周日晚，十一个区域
    switch ($i) {
        case 11:
            $classroom_time_where['period'] = 1;
            break;
        case 12:
            $classroom_time_where['period'] = 2;
            break;
        case 13:
            $classroom_time_where['period'] = 3;
            break;
        case 14:
            $classroom_time_where['period'] = 4;
            break;
        case 15:
            $classroom_time_where['period'] = 5;
            break;
        case 16:
            $classroom_time_where['period'] = 8;
            break;
        case 17:
            $classroom_time_where['period'] = 9;
            break;
        case 18:
            $classroom_time_where['period'] = 10;
            break;
        case 19:
            $classroom_time_where['period'] = 11;
            break;
    }

//确定教学楼和教室
    $start = "（";
    $end = "）";
    $classroom = get_between($classroom_time, $start, $end);
    dump($classroom);
    $building = substr($classroom, 0, -3);
    dump($building);
    $classroom_time_where['number'] = substr($classroom, strlen($building), 3);
//将教学楼名称转化为数据库中的1234
    switch ($building) {
        case '马兰芳教学楼':
            $classroom_time_where['building'] = 1;
            break;
        case '黄浩川教学楼':
            $classroom_time_where['building'] = 2;
            break;
        case '南主楼':
            $classroom_time_where['building'] = 3;
            break;
        default :
            $classroom_time_where['building'] = 4;
    }
    dump($classroom_time_where);
//根据节数不同来确定不同时间
    $time_string = (rtrim(substr($classroom_time, 0, strpos($classroom_time, '（'))));
    dump($time_string);
    $time_data = explode('，', $time_string);
    dump($time_data);

//获取该教室-时间段的id
    $week_section_data['classroom_time_id'] = current(D('ClassroomTime')->getData($classroom_time_where, array('id')));
    dump($week_section_data);
//将这一period内的周数和节数插入数据库并将数据的id用','拼接
    foreach ($time_data as $week_section_combine) {
        dump($week_section_combine);
        //将节数和周数分离
        $week_section_separate = explode('：', $week_section_combine);
        $week_section_data['section_num'] = substr($week_section_separate[1], 0, 1);
        $week = substr($week_section_separate[0], 0, -3);
        dump($week_section_data);
        dump($week);

        //获得周数
        $use_weeks = '';
        if (strpos($week, '、') !== false) {
            $weeks = explode('、', $week);
            dump($weeks);
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
            dump($use_weeks);
        } elseif (strpos($week, '-') !== false) {
            $week_last = explode('-', $week);
            dump($week_last);
            for ($i = $week_last[0]; $i <= $week_last[1]; $i++) {

                $use_weeks .= $i . ',';
            }
        } else {
            $use_weeks .= $week . ',';
        }

        $week_section_data['use_weeks'] = substr($use_weeks, 0, -1);
        dump($week_section_data);
        //将week，section，classroom_time_id数据插入week_section表中
        $result = D('WeekSection')->addOne($week_section_data);
        $week_section_id .= $result['data']['id']. ',';
        dump($week_section_id);
        unset($week_part);
        unset($week_last);
        unset($use_weeks);
    }
}