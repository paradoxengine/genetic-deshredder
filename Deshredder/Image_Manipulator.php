<?php

/**
 * Class: ImageManipulator 
 * Author: Claudio 'BlackFire' Criscione
 * Date: 08/06/2008 [dd/mm/yyyy]
 * The ImageManipulator class is a simple wrapper with methods to manipulate 
 * and blend images using gd
 * 
 **/
class ImageManipulator {
	
	var $convertPath;
	var $d; //Debugging variable

	function __construct($convertPath,$debug = false) {
		$this->convertPath = $convertPath;
        $this->d = $debug;
	}

	
	/**
	 * This method will merge the images provided by the imagenames array
	 * and return a filename pointing to the resulting merging image  
	 **/
	function imageMerge($imagenames = array(), $outputFile = './output.ppm') 
	{
		$imagelist = '';
		foreach($imagenames as $im) {
			$imagelist .= "$im ";
		}
		//shell_exec("$this->convertPath $imagelist +append -contrast -contrast +sharpen 2x2 -depth 4 $outputFile");
		  shell_exec("$this->convertPath $imagelist +append $outputFile");
		  //echo "$this->convertPath $imagelist +append $outputFile";

//		shell_exec("$this->convertPath $imagelist +append  $outputFile");
        if($this->d)  print time() . " IMGMAN: imagemerged \n";
		return $outputFile;
	}
	
}
?>