<?php
/**
 * array_pop — 将数组最后一个单元弹出（出栈）
返回 array 的最后一个值。如果 array 是空（如果不是一个数组），将会返回 NULL 。 
 */
$stack = array("orange", "banana", "apple", "raspberry");
$fruit = array_pop($stack);
print_r($stack);

/**
 * Array
(
    [0] => orange
    [1] => banana
    [2] => apple
)
 
 */
//空数组
$array = array();
$result = array_pop($array);
var_dump($result);
//字符串,报错
//$array = 'sss';
//$result = array_pop($array);
//var_dump($result);
?>
