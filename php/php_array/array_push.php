<?php
//array_push — 将一个或多个单元压入数组的末尾（入栈）
$stack = array("orange", "banana");
array_push($stack, "apple", "raspberry");
print_r($stack);
/**
 *  
Array
(
    [0] => orange
    [1] => banana
    [2] => apple
    [3] => raspberry
)

 */

$stack = array("orange", "banana");
$array2 = array('good','peer');
array_push($stack,$array2);
print_r($stack);
?>
