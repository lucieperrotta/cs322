<?php
include("db.php");
include("functions.php");

$file = fopen("comics/story.csv","r");
$csv = fopen("comics/character.csv", "a+"); 
$has_csv = fopen("comics/has_featured_characters.csv","a+");

echo "<h1>Featuredd Character</h1>";

$index = getLastIndex($csv);

$min = 30200;
$i = 0;

var_dump(fgetcsv($file));

while(! feof($file)){
  $i++;
  $val = fgetcsv($file);

  if($i > $min){

    $id = getInt($val[0]);
    $features = parseDoubleQuoteHas($val[2]);
    //$editing = parseDoubleQuote($val[9]);
    
    if($features!="NULL"){
      $features_array = parseNames($features);
      foreach ($features_array as $p){
        $p = parseComments($p);
        $exist = isInCsvName($csv, $p,1);
        if(!is_numeric($exist)) {
          $add = $index . ",".$p."\n";
          fwrite($csv, $add);

          // has_
          $query = $id.",".$index ."\n";
          fwrite($has_csv, $query);

          $index++;
        }
        else {
          // author exist thus we can add in has_
          $query = $id.",".$exist ."\n";
          fwrite($has_csv, $query);
        }
      }
    }

  }

}
fclose($file);
fclose($csv);


?> 