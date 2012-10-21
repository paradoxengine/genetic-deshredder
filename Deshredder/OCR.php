<?php

/**
 * Class: OCR 
 * Author: Claudio 'BlackFire' Criscione
 * Date: 08/06/2008 [dd/mm/yyyy]
 * The OCR class is a lightweight wrapper around any OCR actually used
 *  
 **/



class OCR {
	
	var $pathToOCR;
    var $d; //Debug variable
	
	function __construct($pathToOCR,$debug = false)	{
		$this->pathToOCR = $pathToOCR;
        $this->d = $debug;
	}
	
	/**
	* This method will translate a given image into the given text file
	**/
	function imageToTextFile($pathToImage, $pathToTextFile = './text') {
		if(file_exists($pathToTextFile))
			unlink($pathToTextFile);
//		$text = shell_exec($this->pathToOCR . ' ' . $pathToImage.'.pnm' . ' > ' . $pathToTextFile);
//patch per tesseract
	      //AGGIUNGIAMO il nobatch ed il riferimento al file di configurazione che elimina tutti i caratteri speciali ed i numeri
		//$text = shell_exec($this->pathToOCR . ' ' . $pathToImage .' ' . $pathToTextFile .' nobatch ./deshredder_tesseract_conf');
		//$text = shell_exec($this->pathToOCR . ' ' . $pathToImage .' ' . $pathToTextFile .' nobatch ./deshredder_tesseract_conf');

		$text = shell_exec('./tesswrap.sh ' . $pathToImage .' > ' . $pathToTextFile );
        if($this->d) print time() . " OCR: ImageToTextFile \n";
		return $pathToTextFile;
	}
	
	/**
	* This method will return the text inside the given image
	**/
	function imageToText($pathToImage) {
		$text = shell_exec($this->pathToOCR . ' ' . $pathToImage);
        if($this->d) print time() . " OCR: ImageToText \n";
		return $text;
	}
	
}


?>