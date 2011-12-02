<?php

//array_multisort(($filesize,$filename,$filedate);
// Array Multisort Function ----------------------------------------------

function csort($array, $order, $column)
{
  $i=0;

      for($i=0; $i<count($array); $i++)
      {
      $sortarr[]=$array[$i][$column];
      }
      
      if($order == "SORT_ASC")
      {
             array_multisort($sortarr, SORT_ASC, $array);
      }
      else
      {
             array_multisort($sortarr, SORT_DESC, $array);
      }

      return($array);
}

?>
