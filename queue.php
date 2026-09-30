<?php

class Queue
{
   var $Url;
   var $Title;
   var $Status;
   var $Depth;

   var $Size;
   var $Marker;

   function Queue()
   {
	$this -> Url = Array(0);
	$this -> Title = Array(0);
	$this -> Status = Array(0);
	$this -> Depth = Array(0);
	
	$this -> Size = 0;
	$this -> Marker = 0;
   }

   function AddUrl($Url, $Title, $Depth)
   {
	$exist = false;

	for ($i=0; $i < $this -> Size; $i++) 
	{
		if (!strcmp($this->Url[$i], $Url))
		{
			$exist = true;
		 	break;
		}
	}
	if (!$exist)
	{
		$idx = $this -> Size;
		$this -> Url[$idx] = $Url;
		$this -> Title[$idx] = $Title;
		$this -> Status[$idx] = 0;
		$this -> Depth[$idx] = $Depth;
		$this -> Size++;
	} 
	
   }

   function ReadUrl($Marker)
   {
	if ($this->Marker < $this->Size)
	{
//		$this->Marker++;
		return $this->Url[$this->Marker];
	}
	else return 0;
   }

   function GetDepth($Marker)
   {
	return $this -> Depth[$Marker];
   }


   function PrintQueue()
   {
	print "<br><b>Queue Size</b> = ".$this -> Size;
	print "<br><b>Urls List</b>:";
	for ($i=0; $i < $this -> Size; $i++) 
	{
		print "<br><b>$i</b>: ".$this -> Url[$i]." => ".$this -> Title[$i]."\t:: Status:".$this->Status[$i]."\t:: Depth:".$this->Depth[$i];

	}
   }

}



?>
