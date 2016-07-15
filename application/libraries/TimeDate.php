<?php

class TimeDate {

	function format($date, $format) {
		$date = trim($date);
		if ($date == '') {
			return '';
		}
		return date($format, strtotime($date));
	}
	function is_date($str) {
		$stamp = strtotime($str);
		if (!is_numeric($stamp)) {
			return FALSE;
		}
		$month = date( 'm', $stamp );
		$day   = date( 'd', $stamp );
		$year  = date( 'Y', $stamp );
		if (checkdate($month, $day, $year)) {
			return TRUE;
		}
		
		return FALSE;		
	}
	function date_compare($date1, $date2) {
		$value1 = (int)date('Ymd', strtotime($date1));
		$value2 = (int)date('Ymd', strtotime($date2));
		if ($value1 == $value2) {
			return 0;
		} else if ($value1 > $value2) {
			return 1;
		} else {
			return -1;
		}
	}
	function date_add($date, $y, $m, $d) {
		$stamp = strtotime($date);
		if (!is_numeric($stamp)) {
			return FALSE;
		}
		$month = date( 'm', $stamp );
		$day   = date( 'd', $stamp );
		$year  = date( 'Y', $stamp );
		$hour = date( 'H', $stamp );
		$min = date( 'i', $stamp );
		$sec = date( 's', $stamp );

		return date('Ymd H:i:s', mktime($hour, $min, $sec, $month + $m, $day + $d, $year + $y));
	}
}
?>
