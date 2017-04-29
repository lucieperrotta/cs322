<?php
include("db.php");
include("functions.php");

//$file = fopen("comics/brand_group.csv","r");
$file = fopen("comics/brand_group_id.csv","r");
$mysql = fopen("brand_group.sql", "w"); // write into this sql to import 


/*
website id ->> mettre dans table website -> remettre foreign key
year -> date
*/

$min = 0;
$max = 3000;
$i = 0;

var_dump(fgetcsv($file));

/*  0 => string 'id' (length=2)
  1 => string 'name' (length=4)
  2 => string 'year_began' (length=10)
  3 => string 'year_ended' (length=10)
  4 => string 'notes' (length=5)
  5 => string 'url' (length=3)
  6 => string 'publisher_id' (length=12)
*/

  while(! feof($file)){
  	$i++;
  	$val = fgetcsv($file);

  	if($i > $min){

  		$id = getInt($val[0]);
  		$name = parseDoubleQuote($val[1]);
  		$year_began = getDateFromYear($val[2]);
  		$year_ended = getDateFromYear($val[3]);
  		$notes = parseDoubleQuote($val[4]);
      //$url = parseDoubleQuote($val[5]);
      $url = getInt($val[5]);

  		$publisher_id = getInt($val[6]);


      if(empty($id)) continue;

  		$query = 'INSERT INTO brand_group(id, name, year_began, year_ended, notes, website_id, publisher_id) VALUES(
  		'.$id.','.$name.','.$year_began.','.$year_ended.',
      '.$notes.','.$url.','.$publisher_id.'
      );';

  	//var_dump($query);

      //print_r($query);
      fwrite($mysql,$query);

      //$s1 = $con->query($query);
      /*var_dump($s1);*/

  		if($i==$max){
  			break;
  		}
  	}
  	
  }

  fclose($file);
  ?> 