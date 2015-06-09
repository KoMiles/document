<?php
//array_fill — 用给定的值填充数组
//array_fill() 用 value 参数的值将一个数组填充 num 个条目，键名由 start_index 参数指定的开始。
$a = array_fill(5, 6, 'banana');
$b = array_fill(-2, 4, 'pear');
print_r($a);
print_r($b);
/**
 *  
Array
(
    [5]  => banana
    [6]  => banana
    [7]  => banana
    [8]  => banana
    [9]  => banana
    [10] => banana
)
Array
(
    [-2] => pear
    [0] => pear
    [1] => pear
    [2] => pear
)
 */
?>
