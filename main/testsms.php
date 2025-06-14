<?php
$ourmessage="Hello, John Doe has successfully reached school at 7:30AM, 3rd April 2025. - New Jerusalem Junior School Kasangati.
";
$ourmessage = urlencode($ourmessage);

$url = "http://www.egosms.co/api/v1/plain/?number=256703611691&message=".$ourmessage."&username=captain&password=0703611691kKq&sender=Egosms";

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