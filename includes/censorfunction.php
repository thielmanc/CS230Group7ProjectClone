<?php
function censor($reviewtext){

    $censoredarray = [];
    
    //splitting strings into arrays for comparison
    $filecontents = file_get_contents('badwords.txt');
    $badwords = preg_split('/[\s]+/', $filecontents, -1, PREG_SPLIT_NO_EMPTY);
    $reviewArr = preg_split('/[\s]+/', $reviewtext, -1, PREG_SPLIT_NO_EMPTY);
    
    foreach ($reviewArr as $word){

      $check = false;
      foreach ($badwords as $swear){
        if ((strtolower($word)) == $swear){
     
          $check = true;
        }
      }
      if ( $check == false){
        array_push($censoredarray, $word);
      } else{
        $bleep = "";
        for($i=0; $i < strlen($word); $i++){
          $bleep .= "*";
        }
        array_push($censoredarray, $bleep);
      }
    }
    $cleanRev =  implode(" ",$censoredarray);
    return $cleanRev;
}