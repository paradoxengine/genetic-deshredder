<?
/**
* The RouletteWheel class is a roulette wheel based, or proportionate fitting, selection
* function
* In fitness proportionate selection the fitness function assigns a fitness to possible 
* solutions or chromosomes. This fitness level is used to associate a probability of 
* selection with each individual chromosome. 
* If fi is the fitness of individual i in the population, its probability of being selected
* is p_i = \frac{f_i}{\Sigma_{j=1}^{N} f_j}, where N is the number of individuals in the population. 
* While candidate solutions with a higher fitness will be less likely to be eliminated, 
* there is still a chance that they may be. Contrast this with a less sophisticated 
* selection algorithm, such as truncation selection, which will eliminate a 
* fixed percentage of the weakest candidates. With fitness proportionate 
* selection there is a chance some weaker solutions may survive the selection process; 
* this is an advantage, as though a solution may be weak, it may include some component 
* which could prove useful following the recombination process.
**/

require_once('Selector.php');

class SelectorRouletteWheel extends Selector {
 
 
 function selectNextGeneration($pop) {
   $ngcount = count($pop) * $this->ng_p;
   $ng = array();
   
   foreach($pop as $i) 
   	$ftot += $this->getFitness($i);
   
   for($c=0;$c < $ngcount;$c++) {
   	foreach($pop as $i) 
   	 if($i->getFitness() / $ftot > rand())
   	 	{
   	 		$ng[]=$i;
   	 		//rimuovi $i da $pop
   	 		continue;
   	 	}
   }
   
   return $ng;
 }
 
 

}

?>