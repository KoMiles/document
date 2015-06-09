<?php
//array_uintersect — 计算数组的交集，用回调函数比较数据
$array1 = array("a" => "green", "b" => "brown", "c" => "blue", "red");
$array2 = array("a" => "GREEN", "B" => "brown", "yellow", "red");

print_r(array_uintersect($array1, $array2, "strcasecmp"));

/**
 *
Array
(
    [a] => green
    [b] => brown
    [0] => red
)
 */

?>
