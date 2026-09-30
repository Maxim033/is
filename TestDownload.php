<?php

function download($host,$url,$port)
{

$fp = fsockopen ($host, $port, $errno, $errstr, 30);
if (!$fp) 
{
    echo "$errstr ($errno)<br>\n";
} 
else 
{
	$in = "GET $url HTTP/1.0\r\n";

	$in .= "user-agent:http://www.cs.vsu.ru; savrn@mail.ru\r\n"; 
	$in .= "Accept-Language:ru\r\n";

	$in .= "\r\n";
	$out = '';

//	echo "Sending HTTP request...$in<br>";

	fputs ($fp, $in);

	echo "OK.<br>";

	$htmlpg = ""; 

	while (!feof($fp)) 
	 {
	        $htmlpg .= fgets ($fp,128);
	 }

	fclose ($fp);
}

//echo $htmlpg;
return $htmlpg;
}


print "<br>Starting....<br>";

$host = "www2.cs.vsu.ru"; 
$url = "http://www2.cs.vsu.ru/~sav/php/WS/index.html";

$htmlpg = download($host,$url,80);

echo $htmlpg;

?>
