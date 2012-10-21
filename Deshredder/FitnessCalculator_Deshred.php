<?
/**
* This class will evaluate the fitness of a given individual, assessing its
* capability to represent a complete document rebuilding the image resulting
* from the given permutations and leveraging the OCR and the iSpell software.
**/

require_once('PHPGeneLIB/FitnessCalculator.php');

class FitnessCalculatorDeshredder {

	/**
	* The path of the temporary text file created via OCR
	**/
	var $txttmp = "./text";
	
	/**
	* If ispell is not in the PATH variable, or if a different ispell has to be 
	* used, a different (complete) path to the ispell software should be provided
	* using the constructor
	**/
	var $ispellpath = '';

	/**
	* Reference to the OCR class wrapping the OCR software to be used
	**/ 
	var $ocr;

    /**
     *Debugging variable
     * @var <type>
     */
    var $d;



  function __construct($ocr, $ispellpath = '/usr/bin/ispell',$d = false) {
	$this->d = $d;
      $this->ispellpath = $ispellpath;
	$this->ocr = $ocr;
  }


 function getFitness($i) {
 	$f = 0; 	
 	//Creating the image
 	$outimage = $i->getMergedImage();
 	//Calculating fitness
 	//$f = $this->getFitnessFromFile($this->ocr->imageToTextFile($outimage, $this->txttmp));
 	$f = $this->getFitnessFromFile($this->ocr->imageToTextFile($outimage, $this->txttmp));
	//cleaning temp files
	//patch per tesseract
//	unlink($this->txttmp);
	unlink($this->txttmp);
	unlink($outimage);
    if($this->d)
    print "Fitness for ".$i->getRepresentation() ."= $f \n";
 	return $f;
 }

	
	
	/**
	* getFitnessFromFile will return the fitness of the given file, evaluating perfect of partial matches
	* Perfect matches are valued twice partial matches
	**/
	function getFitnessFromFile($pathToFile) {
		//$perfect_matches = shell_exec("cat $pathToFile.txt | $this->ispellpath -a | egrep -c '\*|\+'");
		//$almost_matches = shell_exec("cat $pathToFile.txt  | $this->ispellpath -a | grep -c '&'");
		$fitness = shell_exec("./fitness.sh $pathToFile");
//		$fitness = $perfect_matches * 4 + $almost_matches;
		return $fitness;
	}

	/**
	* getFitnessFromText will return the fitness of a given text, evaluating perfect of partial matches
	* Perfect matches are valued twice partial matches
	**/
	function getFitnessFromText($text) {
		$perfect_matches = shell_exec("echo $text | $this->ispellpath -a | grep -c '*'");
		$almost_matches = shell_exec("echo $text  | $this->ispellpath -a | grep -c '+'");
		$fitness = $perfect_matches * 4 + $almost_matches;
		return $fitness;
	}



}

?>