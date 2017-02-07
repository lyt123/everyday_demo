<?php
/* User:lyt123; Date:2017/2/6; QQ:1067081452 */
/* usage of datatime */
date_default_timezone_set('PRC');

// Constructor
$datetime1 = new DateTime();

// stationary format
$datetime2 = new DateTime('2014-04-27 5:03 AM');

// specify date format
$datetime3 = DateTime::createFromFormat('M j, Y H:i:s', 'Jan 2, 2014 23:04:12');

echo $datetime1->format('Y-m-d H:i:s');

/* specify timezone when use DateTime class */
$timezone = new DateTimeZone('America/New_York');
$datetime = new \DateTime('2014-08-20', $timezone);
$datetime->setTimezone(new DateTimeZone('Asia/Hong_Kong'));

/* use of DateInterval */
// Create DateTime instance
$datetime = new DateTime('2017-01-30 14:00:00');

// Create two weeks interval
$interval = new DateInterval('P2W');

// Modify DateTime instance
$datetime->add($interval);
echo $datetime->format('Y-m-d H:i:s');

/* use of DatePeriod(the condition that I'll use it is quite few) */
$start = new DateTime();
$interval = new DateInterval('P2W');
$period = new DatePeriod(
    $start,
    $interval,
    3,
    DatePeriod::EXCLUDE_START_DATE // exclude the start and the end date
);

foreach ($period as $nextDateTime) {
    echo $nextDateTime->format('Y-m-d H:i:s'), PHP_EOL;
}

