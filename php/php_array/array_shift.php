<?php
//array_shift() 将 array 的第一个单元移出并作为结果返回，将 array 的长度减一并将所有其它单元向前移动一位。所有的数字键名将改为从零开始计数，文字键名将不变
$stack = array("orange", "banana", "apple", "raspberry");
$fruit = array_shift($stack);
print_r($stack);

/**
 *  
Array
(
    [0] => banana
    [1] => apple
    [2] => raspberry
)

 */
//数字下标从0开始
$stack = array("orange", "aa"=>"banana", "apple", "bb"=>"raspberry");
$fruit = array_shift($stack);
print_r($stack);

/**
 *  
Array
(
    [aa] => banana
    [0] => apple
    [bb] => raspberry
)
 */
?>
