<?php
/**
* The deshredder main testing class
* @author Claudio Criscione.
* **/

require_once('PHPGeneLIB/GeneLIB.php');
require_once('FitnessCalculator_Deshred.php');
require_once('OCR.php');
require_once('Image_Manipulator.php');
require_once('Individual_Deshred.php');

function pipposort($a, $b)
{
  if (intval($a->getFitness()) == intval($b->getFitness()))  {
    return 0;
  }
  if (intval($a->getFitness()) > intval($b->getFitness())) {
    return -1;
  }
  else {
    return 1;
  }
}



$debug = true;

//Building the environment
//$ocr = new OCR('/usr/bin/gocr',$debug);
//$ocr = new OCR('/usr/bin/ocrad --filter=letters_only',$debug);
$ocr = new OCR('/usr/bin/tesseract ',$debug);
$im = new ImageManipulator('/usr/bin/convert',$debug);
$fc = new FitnessCalculatorDeshredder($ocr,'/usr/bin/ispell',$debug);
$gl = new GeneLIB(10, $fc, new SelectorTournament(), null, $debug);

//Building the base image array
$base = array();

if($debug)
    print time()." - Kernel : Reading input files \n";

$handle = opendir('./input');
while (false !== ($file = readdir($handle))) {
   if ($file != "." && $file != "..") {
         $base[] =  './input/'."$file";
   }
}
closedir($handle);
sort($base);

if($debug)  print time()." - Kernel : Read ".count($base)." files \n";
if($debug)  print time()." - Kernel : Building the population \n";

//Creating fake, contro item
 $genes = array();
 for($c=0; $c < count($base); $c++) {
	 $genes[] = array($c,$c);
 }

 $ind = new IndividualDeshredder($base,$im);
 $ind->setGenes($genes);
// $p[] = $ind;


//Building the population
for($i=0;$i<10;$i++) {
 $genes = array();
 for($c=0; $c < count($base); $c++) {
//	 $genes[] = array(rand(0,count($base)-1),rand(0,count($base)-1));
// Prova di costruzione della popolazione su permutazioni base standard!
	 $genes[] = array($c,rand(0,count($base)-1));
 }
 $ind = new IndividualDeshredder($base,$im);
 $ind->setGenes($genes);
 $p[] = $ind;
}



if($debug)  print time()." - Kernel : Spawned ". count($p) ." individuals \n";


//Creating the new population
$gl->setPopulation($p);
$m = array();
foreach($p as &$pp) {
 $pp->setFitness($fc->getFitness($pp));
}
echo "\n\n";

//TESTING
usort(&$p,"pipposort");


$finalout = array();
$gennum = 0;
while($gennum < 5) {
 echo $p[$gennum]->getRepresentation() . ' First gen Fitness ' . $p[$gennum]->getFitness();
 $finalout[$gennum] = $p[$gennum]->getGenes();
 $gennum++;
}

$p = array();

$ind = new IndividualDeshredder($base,$im);
$a = $finalout[1];
$b = $finalout[4];
array_splice($a,8,count($finalout[1]),array_slice($b,8));
$ind->setGenes($a);
$p[] = $ind;
$ind = new IndividualDeshredder($base,$im);
$a = $finalout[0];
$b = $finalout[4];
array_splice($a,8,count($finalout[1]),array_slice($b,8));
$ind->setGenes($a);
$p[] = $ind;
$ind = new IndividualDeshredder($base,$im);
$a = $finalout[3];
$b = $finalout[2];
array_splice($a,8,count($finalout[1]),array_slice($b,8));
$ind->setGenes($a);
$p[] = $ind;
$ind = new IndividualDeshredder($base,$im);
$a = $finalout[1];
$b = $finalout[3];
array_splice($a,8,count($finalout[1]),array_slice($b,8));
$ind->setGenes($a);
$p[] = $ind;
$ind = new IndividualDeshredder($base,$im);
$a = $finalout[2];
$b = $finalout[4];
array_splice($a,8,count($finalout[1]),array_slice($b,8));
$ind->setGenes($a);
$p[] = $ind;
$ind = new IndividualDeshredder($base,$im);
$a = $finalout[4];
$b = $finalout[1];
array_splice($a,8,count($finalout[1]),array_slice($b,8));
$ind->setGenes($a);
$p[] = $ind;
$ind = new IndividualDeshredder($base,$im);
$a = $finalout[2];
$b = $finalout[1];
array_splice($a,8,count($finalout[1]),array_slice($b,8));
$ind->setGenes($a);
$p[] = $ind;
 
foreach($p as &$pp) {
 $pp->setFitness($fc->getFitness($pp));
}
foreach ($p as $r) {
 echo $r->getRepresentation() . ' Child Fitness ' . $r->getFitness();
}


//MIschio

//FINETESTING



if($debug)  print time()." - Kernel : Creating the first generation of sons \n";
/*
$p = $gl->newGeneration();

if($debug)  print time()." - Kernel : Creating the second generation of sons \n";

$pop = $gl->newGeneration();
foreach($pop as $p) {
	$p->getSolution();
}
*/



?>
