<?php

$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "green", "yellow", "red");
var_dump($array2);
$result = array_diff_assoc($array1, $array2);
print_r($result);
?>
