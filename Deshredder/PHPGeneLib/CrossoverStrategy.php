<?php
/**
 * A crossover strategy class will mate two individuals, generating a new
 * hopefully more fit individual.
 * Since the crossover mechanisms strictly depends on the Individual,
 * the mating strategy has to be implemented in the item.
 * This class is just an interface and should be tweaked accordingly: it will
 * invoke the mating methods choosing between a pool of individuals according
 * to some logic - but the actual mating has to be performed by the individual.
 * It is quite possible for an individual to have multiple mating chances
 */

  class CrossoverStrategy {
  	
  	/**
  	 * This Beltane like function will perform a mating selecting the individuals
  	 * which have to mate.
  	 * In this sample function, we couple the individuals in order and leave the
  	 * odd one alone
  	 * @param $population
  	 * @return unknown_type
  	 */
  	function mate_population($population) {
  		$i = 0;
  		while(count($population) /2 < $i) {
  			$i++;
  		}
  	}
  	
  	
  	
  }

?>