<?php
function censor($reviewtext){

    //censorship function starts here
    $censoredarray = [];
    
    //splitting strings into arrays for comparison
    $filecontents = file_get_contents('includes/badwords.txt');
    $badwords = preg_split('/[\s]+/', $filecontents, -1, PREG_SPLIT_NO_EMPTY);
    $reviewArr = preg_split('/[\s]+/', $reviewtext, -1, PREG_SPLIT_NO_EMPTY);
    
    foreach ($reviewArr as $word){
      $count = 0;
      $check = false;
      foreach ($badwords as $swear){
        if ((strtolower($word)) == $swear){
          $count += 1;
          $check = true;
        }
      }
      if($check == false){
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