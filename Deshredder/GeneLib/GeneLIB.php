<?

require_once('Individual.php');
require_once('FitnessCalculator.php');
require_once('Selector_RouletteWheel.php');
require_once('Selector_Tournament.php');
require_once('Selector.php');


class GeneLIB {

/**
* FitnessCalculator object to be used
**/
var $fitness;


var $d; //Debug controller variable


/**
* Population size of the algorithm
**/
var $psize;

/**
* Selector object to be used
**/
var $selector;

/**
* Crossover strategy to be used
**/
var $crossover_strategy;


/**
* Current population of the algorithm
**/
var $population;

function __construct($psize = 40,$fitness = null, $selector = null,$crossover_strategy = null, $debug = false) {
 $this->d = 1;
 $this->fitness = $fitness;
 $this->psize = $psize;
 $this->selector = $selector;
 $this->selector->setFitnessCalculator($fitness);
 $this->crossover_strategy = $crossover_strategy;
 $this->d = $debug;
}

function setPopulation($p) {
 $this->population = $p;
}

/**
* This function will create a new generation of individuals
* according to the selector, the mutator and the mating algorithms
**/
function newGeneration() {
 if($this->d) echo time()." - GeneLIB : Initial pop = ". count($this->population) . "\n";
 /* Select population */
 $this->population = $this->selector->selectNextGeneration($this->population);
 if($this->d) echo time()." - GeneLIB : Population after tournament =".count($this->population) . "\n";
 /* Now do crossover */
// $this->crossover_strategy->
 if($this->d) echo time(). " - GeneLIB: Final pop = ". count($this->population) . "\n";
 //Do mating, do mutation
 return $this->population;
}



}
?>