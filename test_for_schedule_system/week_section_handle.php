<?php
/* User:lyt123; Date:2016/11/2; QQ:1067081452 */
for ($i = 11; $i < 20; $i++) {
    $classroom_time = $item[$i];
    dump($classroom_time);
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
        dump($classroom_time_where);
        //确定教学楼和教室
        $start = "（";
        $end = "）";
        $classroom = get_between($classroom_time, $start, $end);
        dump($classroom);
        $building = substr($classroom, 0, -3);
        dump($building);
        $classroom_time_where['number'] = substr($classroom, strlen($building), 3);
        dump($classroom_time_where);
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
        dump($classroom_time_where);;
        //根据节数不同来确定不同时间
        $time_string = (rtrim(substr($classroom_time, 0, strpos($classroom_time, '（'))));
        dump($time_string);
        $time_data = explode('，', $time_string);
        dump($time_data);

        //将这一period内的数据插入数据库并将数据的id用','拼接
        foreach ($time_data as $week_section) {
            dump($week_section);
            //节数
            $week_section = explode('：', $week_section);
            $classroom_time_data['section_num'] = substr($week_section[1], 0, 1);
            $week_section[0] = substr($week_section[0], 0, -3);
            dump($week_section);

            //周数
            $use_weeks = '';
            if (strpos($week_section[0], '、') !== false) {
                $weeks = explode('、', $week_section[0]);
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
                dump($week_last);
                for ($i = $week_last[0]; $i <= $week_last[1]; $i++) {

                    $use_weeks .= $i . ',';
                }

            } else {
                $use_weeks .= $week_section[0] . ',';
            }

            $classroom_time_data['use_weeks'] = substr($use_weeks, 0, -1);
            dump('nice');
            $classroom_time_id = D('WeekSection')->updateWeekSection($classroom_time_where, $classroom_time_data);
//                        dd($classroom_time_id);

            $classroom_time_ids .= $classroom_time_id . ',';
            dump($classroom_time_ids);
            dump($classroom_time_data);
            dump($classroom_time_where);
            unset($weeks);
            unset($week_part);
            unset($week_last);
            unset($use_weeks);
        }
        dd($classroom_time_ids);
    }
}