<?php

include_once("queue.php");

//$init_queue = Array("http://localhost:8000/xampp/index.php");
//$init_queue = Array("http://www.sc.vsu.ru/");
$init_queue = Array("http://www2.cs.vsu.ru/~sav/php/WS/index.html");


//$visitedUrls = Array(0);

$queue = new Queue();

error_reporting (E_ALL);

function download($service, $protocol, $host, $service_port, $url)
{

$fp = fsockopen ($host, $service_port, $errno, $errstr, 30);
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

	echo "Sending HTTP request...$in<br>";

	fputs ($fp, $in);

	echo "OK.<br>";

	$htmlpg = ""; 

	while (!feof($fp)) 
	 {
	        $line = fgets ($fp,2048);
//		echo $line."<br>";
		$htmlpg .= $line;
	 }

	fclose ($fp);
}

//echo $htmlpg;

return $htmlpg;
}

preg_match("/^((http|ftp|mailto):\/\/)?([^\/]+)(.*)\/[^\/]*$/i", $init_queue[0], $matches);

$root = $matches[1].$matches[3].$matches[4];
$host = $matches[3];

print "root::$root<br><br>";

$htmlpg = strtolower(download('www','tcp', $host, 80, $init_queue[0]));

preg_match("/^((http|ftp|mailto):\/\/)?([^\/]+)(.*)\/[^\/]*$/i",$init_queue[0], $m);

$depth = 1;
$parent = $init_queue[0];
$protocol = $m[2];
$host = $m[3];
$path = $m[4];

print "<br><b>host</b>: ".$host." <b>path</b>: ".$path;

preg_match_all ("/<a href=\"([^\">]*)\"[^\">]*>([^\">]*)<\/a>/", $htmlpg, $matches);

// searching for relative URLs

for ($j=0; $j< count($matches[1]); $j++) 
{
  $url = $matches[1][$j];

  preg_match("/(http|mailto|ftp)(.*)/", $url, $matches2);
  if (!($matches2))
  {	

	preg_match("/^(\.{2}\/?)(.*)/", $url, $matches2);
	if ($matches2)
	{
		$url = $root."/".$matches2[2];			
	}
	else
	{
		preg_match("/^(\.{1}\/)?(.*)/", $url, $matches2);
		if ($matches2)
			$url = $protocol."://".$host.$path."/".$matches2[2];
		else

			$url = $parent.$url;				
	}
  }
  $queue->AddUrl($url, $matches[2][$j],$depth);
}

$queue->PrintQueue();

$i=0;

while ($url = $queue->ReadUrl($queue->Marker))
{
	print "<br>$i Url to download: ".$url."<br>";
	$htmlpg = strtolower(download('www','tcp', $host, 80, $url));

	preg_match("/^http\/\d\.\d\s(\d{3})\s(.+)/i", $htmlpg, $matches);
	$status = $matches[1];
	print "Status: ".$status."<br>";
	$i++;

	if ($status != 200)
	{
		$queue->Status[$queue->Marker] = 1;
		$queue->Marker++;
	}
	else
	{
		$depth = $queue->GetDepth($queue->Marker);

		$queue->Status[$queue->Marker] = 2;
		$queue->Marker++;
		$depth++;

		preg_match_all ("/<a href=\"([^\">]*)\"[^\">]*>([^\">]*)<\/a>/", $htmlpg, $matches);

		preg_match("/^((http|ftp|mailto):\/\/)?([^\/]+)(.*)\/[^\/]*$/i",$url, $m);

		$parent = $url;
		$protocol = $m[2];
		$host = $m[3];
		$path = $m[4];

		print "<b>host</b>: ".$host." <b>path</b>: ".$path;

		// searching for relative URLs

		for ($j=0; $j< count($matches[1]); $j++) 
		{
		  	$url = $matches[1][$j];
  			preg_match("/(http|mailto|ftp)(.*)/", $url, $matches2);
	  		if (!($matches2))
	  		{	
				preg_match("/^(\.{2}\/?)(.*)/", $url, $matches2);
				if ($matches2)
				{
					$url = $root."/".$matches2[2];			
				}
				else
				{
					preg_match("/^(\.{1}\/)?(.*)/", $url, $matches2);
					if ($matches2)
						$url = $protocol."://".$host.$path."/".$matches2[2];
					else
			
						$url = $parent.$url;					
				}
 	 		}
  			$queue->AddUrl($url, $matches[2][$j], $depth);
		}
	}
	print "<br><b>Size:</b>".$queue->Size."<br>";

$queue->PrintQueue();
}


?>
