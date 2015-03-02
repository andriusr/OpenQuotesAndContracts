<?php
// $timeA = '27.01.1756';
// $timeB = date("d.m.Y");
// 
// $mozart = seDay($timeA,$timeB,"dmY",".");
// echo 'Wolfgang Amadeus Mozart wäre heute ' . $mozart . ' Tage alt';
function DaysBetweenStr($begin, $end, $format, $sep){
	$pos1 = strpos($format, 'd');
	$pos2 = strpos($format, 'm');
	$pos3 = strpos($format, 'Y');
	
	$begin = explode($sep,$begin);
	$end = explode($sep,$end);
	
	$first = GregorianToJD($end[$pos2],$end[$pos1],$end[$pos3]);
	$second = GregorianToJD($begin[$pos2],$begin[$pos1],$begin[$pos3]);
	
	if($first > $second)
		return $first - $second;
	else
		return $second - $first;
} 

function DaysBetween_($date1_year, $date1_month, $date1_day, $date2_year, $date2_month, $date2_day)
{
	$first = GregorianToJD($date1_month, $date1_day, $date1_year);
	$second = GregorianToJD($date2_month, $date2_day, $date2_year);
	
	if($first > $second)
		return $first - $second;
	else
		return $second - $first;
} 

function DaysBetween($date1, $date2)
{
	$date1 = getdate($date1); 
	$date2 = getdate($date2); 
	
	$first = GregorianToJD($date1[mon], $date1[mday], $date1[year]);
	$second = GregorianToJD($date2[mon], $date2[mday], $date2[year]);
	
	if($first > $second)
		return $first - $second;
	else
		return $second - $first;
} 


function MonthsBetween($date1, $date2)
{
	$months = 0;
	
	// Sicherstellen, dass date1 vor date2 liegt
	if ($date1 > $date2)
	{
		$datebackup = $date1;
		$date1 = $date2;
		$date2 = $datebackup;
	}

	$date1 = getdate($date1); 
	$date2 = getdate($date2); 

	$months += ($date2['year'] - $date1['year'] - 1) * 12;
	$months += (12 - $date1['mon']); 
	$months += $date2['mon'];
	$months += 1;
	
	if ($months < 1)
	  $months = 1;
	  
	return $months;	
}

// Konvertiert ein Datumsformat der Form 'YYYY-DD-MM HH:MM:SS' in ein PHP-Datum
function from_db($date)
{
/*	$datestr = substr($date, 0, 3);

	$datestr .= 'a';
	
	return strtotime($datestr);*/
	
    return strtotime($date);	
}

?>