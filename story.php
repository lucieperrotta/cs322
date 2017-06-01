<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story.csv","r");
$mysql = fopen("story_5.csv", "w"); // write into this sql to import 


$min = 702819; // 335819
$max = 802819; // 838803
$i = 0;

var_dump(fgetcsv($file));

while(! feof($file)){
 $i++;
 $val = fgetcsv($file);

 if($i > $min){

  $id = getInt($val[0]);
  $title = parseDoubleQuote($val[1]);
  $issue_id = getInt($val[3]);
  $synopsis = parseDoubleQuote($val[12]);
  $reprint_notes = parseDoubleQuote($val[13]);
  $notes = parseDoubleQuote($val[14]);
  $type_id = getInt($val[15]);

  if(!isset($type_id)) continue;
  if(!isset($issue_id)) continue;
  if(!isset($title)) continue;
  if(!isset($synopsis)) continue;
  if(!isset($reprint_notes)) continue;
  if(!isset($type_id)) continue;
  if(!isset($notes)) continue;

  if($type_id==3) {
      $type_id = "NULL"; // backover do not use
    }


    $query = $id.','.$title.','.$issue_id.','.$synopsis.','.$reprint_notes.','.$notes.','.$type_id.'
    ';

    if(strpos($query, ",,")===false){
      fwrite($mysql,$query);
    }


  	//var_dump($query);


    if($i==$max){
     break;
   }
 }


}

fclose($file);
?> 