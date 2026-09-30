<?php

$fnlist = array("yandex.htm");

$string = "";
$td = array(0);

$n = count($fnlist);
for ($i=0; $i < $n; $i++)
{
  	$fname = $fnlist[$i];
  	$fh = fopen ($fname, "r");
  	if (!$fh) die("cannot open file $fname");
  	while (!feof ($fh)) 
	{
    		$buffer = fgets($fh, 4096);
    		echo $buffer;
    		$string .= $buffer;
	}
  	fclose ($fh);

	$string = strip_tags(stristr($string, "<html"));

	$keywords = preg_split ("/[\s«»\"\[\]\(\),\.;:\-!\?\/]+/", strtolower($string), -1, PREG_SPLIT_NO_EMPTY);

	$freq = array_count_values($keywords);

	while (list($key, $value) = each($freq)) 
	{
		if (!array_key_exists($key, $td)) $td[$key] = array_fill(0,$n,0);
		$td[$key][$i] = $value;
	}

}

ksort($td);
print "<br><br>\n";
while (list($key, $value) = each($td)) 
{
	print "$key:\t";
	for ($i = 0; $i < $n; $i++) print "$value[$i]\t";
	print "<br>\n";
}


?>
