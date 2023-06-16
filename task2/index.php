<?php

/**
 * @charset UTF-8
 *
 * Задание 2. Работа с массивами и строками.
 *
 * Есть список временных интервалов (интервалы записаны в формате чч:мм-чч:мм).
 *
 * Необходимо написать две функции:
 *
 *
 * Первая функция должна проверять временной интервал на валидность
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм)
 * 	возвращать boolean
 *
 *
 * Вторая функция должна проверять "наложение интервалов" при попытке добавить новый интервал в список существующих
 * 	принимать она будет один параметр: временной интервал (строка в формате чч:мм-чч:мм). Учесть переход времени на следующий день
 *  возвращать boolean
 *
 *  "наложение интервалов" - это когда в промежутке между началом и окончанием одного интервала,
 *   встречается начало, окончание или то и другое одновременно, другого интервала
 *
 *
 *
 *  пример:
 *
 *  есть интервалы
 *  	"10:00-14:00"
 *  	"16:00-20:00"
 *
 *  пытаемся добавить еще один интервал
 *  	"09:00-11:00" => произошло наложение
 *  	"11:00-13:00" => произошло наложение
 *  	"14:00-16:00" => наложения нет
 *  	"14:00-17:00" => произошло наложение
 */

const TIME_COMPONENT_LENGTH = 2;
const START_POS_START_HOURS = 0;
const START_POS_START_MINUTES = 3;
const START_POS_END_HOURS = 6;
const START_POS_END_MINUTES = 9;

const MAX_HOURS = 23;
const MAX_MINUTES = 59;

/** 
 * Условимся, что если начало интервала меньше конца, то это всё ещё валидный интервал. 
 * Иначе было бы не соблюсти условие про переход на другой день.
 * То есть, интервал 11:30-05:23 валиден. Просто затрагивает следующий день.
 * Также тогда надо как-то знать интерваллы следующего дня. Условимся, что данный список
 * интерваллов распространяется одинаково на следующий день.
*/

function getTimeValuesFromTimeInterval($timeInterval){
	$startHours = intval(substr($timeInterval, START_POS_START_HOURS, TIME_COMPONENT_LENGTH)); 
	$startMinutes = intval(substr($timeInterval, START_POS_START_MINUTES, TIME_COMPONENT_LENGTH)); 
	$endHours = intval(substr($timeInterval, START_POS_END_HOURS, TIME_COMPONENT_LENGTH)); 
	$endMinutes = intval(substr($timeInterval, START_POS_END_MINUTES, TIME_COMPONENT_LENGTH)); 
	return array(
		0 => $startHours, 
		1 => $startMinutes, 
		2 => $endHours, 
		3 => $endMinutes
	);
}

function validateTimeInterval($timeInterval) {
	$regex = '/\\d\\d:\\d\\d-\\d\\d:\\d\\d/i';
	if (!preg_match($regex, $timeInterval)) {
		return false;
	} else {
		$timeValues = getTimeValuesFromTimeInterval($timeInterval);
		if($timeValues[0] > MAX_HOURS || $timeValues[2] > MAX_HOURS || $timeValues[1] > MAX_MINUTES || $timeValues[3] > MAX_MINUTES) {
			return false;
		} else {
			return true;
		}
	}
}

function parseTimeIntervalToSeconds($timeInterval){
	if(!validateTimeInterval($timeInterval)){
		return null;
	} else {
		$timeValues = getTimeValuesFromTimeInterval($timeInterval);
		$startSeconds = $timeValues[0] * 3600 + $timeValues[1] * 60;
		$endSeconds = $timeValues[2] * 3600 + $timeValues[3] * 60;
		return array(
			0 => $startSeconds, 
			1 => $endSeconds
		);
	}
}

function checkTimeIntervalNotOverlay($timeInterval){
	if(!validateTimeInterval($timeInterval)){
		return false;
	}

	$list = array (
		"10:00-14:00",
		"16:00-20:00"
	);

	$targetTimeValues = parseTimeIntervalToSeconds($timeInterval);
	$targetStartSeconds = $targetTimeValues[0];
	$targetEndSeconds = $targetTimeValues[1];

	foreach($list as $initTimeInterval){
		$intervalsInSeconds = parseTimeIntervalToSeconds($initTimeInterval);
		$startSeconds = $intervalsInSeconds[0];
		$endSeconds = $intervalsInSeconds[1];

		if(($endSeconds > $targetStartSeconds) && ($targetEndSeconds > $startSeconds)) {
			return false;
		}
	}

	if($targetStartSeconds > $targetEndSeconds) {
		if(($targetEndSeconds > parseTimeIntervalToSeconds($list[0])[0]) || (parseTimeIntervalToSeconds(end($list))[1] > $targetStartSeconds)){
			return false;
		} else {
			return true;
		}
	} else {
		return true;
	}
}

$timeIntervalToCheck = "21:00-05:00";
var_dump(validateTimeInterval($timeIntervalToCheck));
var_dump(checkTimeIntervalNotOverlay($timeIntervalToCheck));

?>