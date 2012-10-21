<?
/**
* An individual for the deshredder project, consisting of a set of pages
* obtained through iterations of the acquired parts
**/

require_once('PHPGeneLIB/Individual.php');

class IndividualDeshredder extends Individual {
	/**
	* Each individual's genes are a set of "swaps" between an input order base
	* which is here described as an array of files
	**/
	var $base;
	
	/**
	* im, Image Merger, is the class able to rebuild and manipulate images
	**/
	var $im;

    //Debugger variable
    var $d = true;

	
	function __construct($base, $im) {
		$this->base = $base;
		$this->im = $im;
	}
	
	function getFitness() {
 		// echo "Fitness for ". $this->printGenes() . " = ".$this->fitness . "\n";
 	 	return $this->fitness;
	 }
	
	
	function setBase($base) {
		$this->base = $base;
	}
	
	function setImageMerger($im) {
		$this->im = $im;
	}
	
	
	/**
	* Helper function to get a representation of the individual
	* using the order of the images
	**/
	function getRepresentation() {
	 $n = count($this->genes) + 1;
	 $rep = array();
	 for($i=1;$i<$n;$i++) $rep[] = $i;

	 for($i=1;$i<($n-1);$i++) {
	    $t = $rep[$this->genes[$i][0]];
	    $rep[$this->genes[$i][0]] = $rep[$this->genes[$i][1]];
	    $rep[$this->genes[$i][1]] = $t;
	 }
	 $lrep = '';
	 foreach($rep as $g) $lrep .= $g . ',';

	 //Since in our tests items are progressive, let's count progressive
	 $cprog = 0;
	 for($i=0;$i<count($rep)-1;$i++) 
	    if(($rep[$i+1]-$rep[$i]) == 1) $cprog ++;
	 $lrep .= " $cprog couple in order";
	 return $lrep;
	}

	
	/**
	* getMergedImage will return a file path pointing to the image resulting
	* from the merge of the images as per the swapping
	**/
	function getMergedImage($imgname = 'output.tif') {
		$img = $this->base;
		foreach($this->genes as $g) {
			$t = $img[$g[0]];
			$img[$g[0]] = $img[$g[1]];
			$img[$g[1]] = $t;
		}
		$outimage = $this->im->imageMerge($img,$imgname);
		return $outimage;
	}
	
	
	/**
     *Prints the genome of this invidivudal
     * @return <type>
     */
	function printGenes() {
	 foreach($this->genes as $g) {
	   $s .= "[".$g[0].','.$g[1]. "]";
	 }
	 return $s;
	}
	
	
   function getSolution() {
     if(!$this->d) return; //onyl enabled in debug mode
     echo "-------------\n";
     echo $this->getRepresentation();
/*	 echo "------- \n";
     $o = $this->base;
   	 foreach($this->genes as $g) {
   	   $temp = $o[$g[0]];
   	   $o[$g[0]] = $o[$g[1]];
   	   $o[$g[1]] = $temp;
	 }
	 echo "Fitness for this individual, ". $this->printGenes() . "is ". $this->getFitness() ."\n";
	 echo "Order of files:\n";
	 foreach($o as $f) {
	 	echo "- $f \n";
	 }
      $rnd='';
     foreach($o as $f)
      { $rnd .= $f['11'].$f['12'].'-';
	  }
        $rnd.='.jpg';
     echo "Filename = $rnd - Fitness: ".$this->getFitness()."\n";
     $this->getMergedImage($rnd);
	 echo "------- \n";*/
   }
}

?>