<?

//$a = array('00','01','02','03','11','10','09','08','07','06','05','04'); //4 -26
//$a = array('00','01','02','03','04','11','10','09','08','07','06','05'); //5 -26
//$a = array('00','01','02','03','04','05','11','10','09','08','07','06'); //6 -32
//$a = array('00','01','02','03','04','05','06','07','11','10','09','08'); //8 -30
//$a = array('00','01','02','11','04','05','06','07','08','09','10','03'); //9 -30
//$a = array('00','01','02','11','09','05','06','07','08','04','10','03'); //8 -22
//$a = array('00','01','02','11','04','05','06','07','08','09','10','03');
//$a = array('00','01','02','11','04','05','06','07','08','09','10','03');
//$a = array('00','01','02','11','04','05','06','07','08','09','10','03');
//$a = array('00','01','02','11','04','05','06','07','08','09','10','03');
//$a = array('00','11','02','01','04','05','06','07','08','09','10','03'); //7 -22


$a = array('00','01','02','03','04','05','06','07','08','09','10','11','12','13','14','15','16'); //16-40
$a = array('00','11','02','03','04','05','06','07','08','09','10','01','12','13','14','15','16'); //14-30
$a = array('00','11','02','03','04','05','06','07','14','09','10','01','12','13','08','15','16'); //12-24
$a = array('03','11','02','00','04','05','06','07','14','09','10','01','12','13','08','15','16'); //10-18
$a = array('03','11','10','00','04','05','06','07','14','09','02','01','12','13','08','15','16'); //8-10
$a = array('03','11','10','00','04','05','06','07','14','09','02','01','16','13','08','15','12'); //6-6
$a = array('03','11','10','00','04','15','06','07','14','09','02','01','16','13','08','05','12'); //4-4
$a = array('00','01','02','03','04','05','06','07','08','09','10','16','15','14','13','12','11'); //11-24
$a = array('00','01','02','16','04','05','06','12','08','09','10','11','07','13','14','15','03'); //13-26
$a = array('03','10','15','14','04','02','01','06','09','08','12','13','11','05','16','07','17');
$a = array('02','00','15','03','04','05','06','07','13','09','10','11','12','01','16','08','14'); //7 coppie
$ca =  "/usr/bin/convert ";

foreach($a as $b) {
  $ca.= " ./input/true_small_$b.tif";

}
$ca .= " +append output.tif";

shell_exec($ca);
shell_exec('./tesswrap.sh  output.tif > test.txt');
$tot = shell_exec('./fitness.sh test.txt');
echo $tot;

?>