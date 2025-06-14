<?php
date_default_timezone_set('Africa/Kampala');
if ($action=="arrived") {$actionreader="Successfully Reached";}
elseif ($action=="left") {$actionreader="Just Left";}
else {$actionreader="";}

$raw_date = $our_date; // Input date in 'YYYY-MM-DD' format
$date_object = new DateTime($raw_date);
// Format the date to '3rd March 2025'
$datetoread = $date_object->format('jS F Y');
//echo $datetoread; // Output: 3rd April 2025

$raw_time = $our_time; // Input time in 'HH:mm:ss' format
$time_object = new DateTime($raw_time);
// Format the time to 12-hour format with AM/PM
$timeread = $time_object->format('g:i A');
//echo $timeread; // Output: 1:38 AM

$ourmessage="Hello, ".$student_fname." has ".$actionreader." school at ".$timeread.", ".$datetoread.". - New Jerusalem Junior School Kasangati.
";
$ourmessage = urlencode($ourmessage);

$url = "http://www.egosms.co/api/v1/plain/?number=256702128090&message=".$ourmessage."&username=captain&password=0703611691kKq&sender=Egosms";
//0743961254
//0760745893
//0702128090 Nasser
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url); 
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/6.0 (Windows; U; Windows NT 5.1; en-US; rv:1.7.7) Gecko/20050414 Firefox/1.0.3");
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER,1); 
$result = curl_exec ($ch); 
curl_close ($ch);


?>