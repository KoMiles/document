<?php
//array_slice — 从数组中取出一段
$input = array("a", "b", "c", "d", "e");

$output = array_slice($input, 2);      // returns "c", "d", and "e"
$output = array_slice($input, -2, 1);  // returns "d"
$output = array_slice($input, 0, 3);   // returns "a", "b", and "c"

$array = array(1,2,3,4,5,6,7,8,9,10,11);
$page  = 3;
$limit = 3;
$start = ($page-1) * $limit;
$result = array_slice($array, $start, $limit);
var_dump($result);
?>
