<?php

//array_multisort(($filesize,$filename,$filedate);
// Array Multisort Function ----------------------------------------------

function csort($array, $column){
  $i=0; 
  for($i=0; $i<count($array); $i++){ 
   $sortarr[]=$array[$i][$column]; 
  } 

  array_multisort($sortarr, $array);  

  return($array); 
}

// End of Array Function -------------------------------------------------

?>
