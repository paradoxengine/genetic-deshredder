<?
/**
* The Tournament class implements a tournament based selection method
* Tournament selection is one of many methods of selection in genetic algorithms which 
* runs a "tournament" among a few individuals chosen at random from the population and
* selects the winner (the one with the best fitness) for crossover.
* Selection pressure can be easily adjusted by changing the tournament size. 
* If the tournament size is larger, weak individuals have a smaller chance to be selected.
**/
require_once('Selector.php');

class SelectorTournament extends Selector {
 
 /**
 * Tournament size percentage - the size of the tournament
 * itself as a percentage on the total population
 **/
 var $tsp = 0.30;
 
 /**
 * Tournament difficulty - percentual chance of the first item
 * to be the winner of the tournament
 **/
 var $td = 0.9; 
 
 var $d = true; //debugging variable

 function selectNextGeneration($pop) {
   $ngcount = ceil(count($pop) * $this->ng_p);
   if($this->d) echo time() . " - TournamentSelector: Next Generation will have $ngcount individuals \n";
   $tsize = ceil(count($pop)  * $this->tsp);
   $ng = array();

   //Repeat for each tournament
   for($c=0;$c < $ngcount;$c++) {   
   	   $titems = array();

	   //Select tsize random items
	   for($i=0;$i < $tsize;$i++) 
	   	$titems[] = $pop[rand(0,count($pop)-1)];

   	   //Create an array with fitness as the key value
	   $tit = array();
   	   foreach($titems as $i) {
  	     $tit[$this->getFitness($i)]=$i;
  	     //TODO QUESTA COSA NON VA BENE! MI COLLASSA ROBI CON LO STESSO VALORE DI FITNESS!
   	   }
   	   
   	   //Sort the array
   	   rsort($tit);
   	   $i=0;
        if($this->d) echo time(). " - SelectorTournament: ". count($tit) . " elements in tit array \n";
	   /**
	   * We use $td at each iteraction, since having previously not selected
	   * the item means having satisfied the 1-p probability requirements of the
	   * formula.
	   **/ 
	   $selected = false;
   	   foreach($tit as $tk=>$tv)
   	   	if(rand() < ($this->td)) {
   	   		$selected = true;
   	   		$ng[] = $tv;   	  
   	   	}	   
   if( $this->debug) echo time(). " - SelectorTournament : Selected items count = ".count($ng)."\n";
   	   //it might happen that we have not selected any individual. If it is so, we choose the first one
   	   if(!$selected) $ng[] = $tit[0];
   }
   if($this->d) time() . " - SelectorTournament: Final selected items count = ".count($ng)."\n";
   return $ng;
 }
 
 

}

?>