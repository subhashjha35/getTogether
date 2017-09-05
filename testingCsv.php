<?php

$file=fopen("resources/occupations.csv", "r");
$arr=Array();
while(($line=fgetcsv($file,null,"\n"))!=false){
    $arr[]=$line;
}
print_r($arr);

fclose($file);