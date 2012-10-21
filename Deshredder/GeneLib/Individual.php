<?

/**
* this class descxribes a single individual in GeneLIB
**/ 
class Individual {
 /**
 * The fitness of this individual, which can be cached
 **/
 var $fitness;
 
 /**
 * Genes of this individual
 **/
 var $genes;

 function getFitness() {
 	return $this->fitness;
 }
 
 function setFitness($fitness) {
 	$this->fitness = $fitness;
 }
 
 function getGenes() {
 	return $this->genes;
 }
 
 function setGenes($genes) {
 	$this->genes = $genes;
 }

 function getRepresentation() {
	return "Individual";
 }
 
 /**
 * getSolution should be able to propose the solution contained in the genes of this individual
 * in a way that is processable by the application
 */
 function getSolution() {
 	echo "getSolution was not implemented, this is a severe error!";
 }
 
 
}
?>