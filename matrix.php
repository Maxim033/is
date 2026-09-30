<?php

$fnlist = array("yandex.htm","RUmetrics.htm");

$string = "";
$td = array(0);

$c = array_fill(0,40,0);

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

	$keywords = preg_split ("/[\s«»\"\[\]\(\),.;:\-!\?\/]+/", strtolower($string), -1, PREG_SPLIT_NO_EMPTY);

	$freq = array_count_values($keywords);

	while (list($key, $value) = each($freq)) 
	{
		if (!array_key_exists($key, $td)) $td[$key] = array_fill(0,$n,0);
		$td[$key][$i] = $value;
	}

}

ksort($td);
print "<br><br>\n";
{
	print "$key:\t";
	for ($i = 0; $i < $n; $i++) print "$value[$i]\t";
	print "<br>\n";
}

$dd = array(0);
for ($i=0; $i < $n; $i++)
{
	$dd[$i] = array_fill(0,$n,0);
	for ($j=$i; $j < $n; $j++)
	{
		foreach ($td as $key => $value)
		{
			if ($value[$i] * $value[$j] > 0) $dd[$i][$j]++;
		}
	}
}



print "<br>Doc-Doc matrix:<br>";
for ($i=0; $i < $n; $i++)
{
	print "$i: ";
	for ($j=0; $j < $n; $j++) print " ".$dd[$i][$j]." ";
	print "<br>";

}
$keys = array_keys($td);
$m = count($keys);
//$m=10;

$tt = array(0);
for ($i=0; $i < $m; $i++)
{

	$tt[$i] = array_fill(0,$m,0);
	for ($j=$i; $j < $m; $j++)
	{
		$t1 = $keys[$i];  $t2 = $keys[$j];
		for ($k=0; $k < $n; $k++)
		{
			if ($td[$t1][$k] * $td[$t2][$k] > 0) 
				$tt[$i][$j]++;
		}
	}
}

//print_r($tt);

print "<br>Term-Term matrix:<br>";
print "<table><tr><td>   </td>";
for ($j=0; $j < $m; $j++) print "<td>$j</td>";
print "</tr>";
for ($i=0; $i < $m; $i++)
{
	print "<tr>";
	print "<td>$i: </td>";
	for ($j=0; $j < $m; $j++) print "<td> ".$tt[$i][$j]." </td>";
	print "</tr>";

}
print "</table>";

?>
