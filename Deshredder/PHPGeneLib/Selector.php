<?
/****
* Selector is an abstract class providing selection function 
* to the GeneLIB framework
* 
*****/

class Selector {
 /** Debugger level **/
 var $d;

 /** FCalc is the fitness calculator */
 var $FCalc;

 /** NextGeneration percentage is the percentage of the current
 * population which will be carried over to the next
 * generation **/
 var $ng_p = 0.3;

 function setFitnessCalculator($Fcalc) {
 	$this->Fcalc = $Fcalc;
 }

 /**
 * Returns the fitness of individual $i
 **/
 function getFitness($i) {
  if($i->getFitness() == null) {
  	$ft = $this->Fcalc->getFitness($i);
  	$i->setFitness($ft);
  }
  else {
  	$ft = $i->getFitness();
  }
  return $ft;
 }

 /**
 * this function will return the next generation of the population
 * given the current array of individuals
 **/
 function selectNextGeneration($population) {}
 
 
 
}
?>