<?php
//array_unique — 移除数组中重复的值
$array1 = array('a','cc'=>'b','a','d','b','e');
$re = array_unique($array1);
var_dump($re);
echo "\n";
$array1 = array('a','b','a','d','bb'=>'b','e');
$re = array_unique($array1);
var_dump($re);
