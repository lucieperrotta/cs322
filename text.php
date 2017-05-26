<?php

include("db.php");
include("functions.php"); 

$csv = fopen("comics/artist.csv", "a+"); 
$file = fopen("comics/issue.csv","r");
//$file = fopen("comics/story.csv","r");
//$has_editing = fopen("comics/has_editing_story.csv", "w+"); 
//$has_editing = fopen("comics/has_colors.csv", "w+"); 
//$has_editing = fopen("comics/has_script.csv", "w+"); 
//$has_editing = fopen("comics/has_pencils.csv", "w+"); 
//$has_editing = fopen("comics/has_letters.csv", "w+"); 
$has_editing = fopen("comics/has_editing_issue.csv", "w+");  

// 4996 last working inks

$index = getLastIndex($csv);

$min = 9000;
$max = 1000000000;
$i = 0;

var_dump(fgetcsv($file));

while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i < $min) continue;

  $id = getInt($val[0]);
  //$editing = parseDoubleQuote($val[9]);
  $editing_issue = parseDoubleQuote($val[8]);
  //$inks = parseDoubleQuote($val[6]);
  //$colors = parseDoubleQuote($val[7]);
  //$script = parseDoubleQuote($val[4]);
  //$letters = parseDoubleQuote($val[8]);

    //$pencils = parseDoubleQuote($val[5]);

  if($editing_issue!="NULL"){
    $editing_array = parseNames($editing_issue);
    foreach ($editing_array as $p){
      $p = parseComments($p);
      if($p == "NULL") continue;
      $exist = isInCsvName($csv, $p,1);
      if(!is_numeric($exist)) {
          // if author does not exist, add it in csv and has_
        $add = $index . ",".$p."\n";
        fwrite($csv, $add);

        $query = $id.",".$index ."\n";
        fwrite($has_editing, $query);

        $index++;
      }
      else {
          // author exist thus we can add in has_

        $query = $id.",".$exist ."\n";
        fwrite($has_editing, $query);
      }
    }
  }


  if($i==$max){
    break;
  }
}



fclose($file);
fclose($csv);


?> 