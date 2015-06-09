<?php
/**
 * array_count_values — 统计数组中所有的值出现的次数 
 * array_count_values() 返回一个数组，该数组用 input 数组中的值作为键名，该值在 input 数组中出现的次数作为值。
 */

$array = array(1, "hello", 1, "world", "hello");
print_r(array_count_values($array));
/**
 *result
Array
(
    [1] => 2
    [hello] => 2
    [world] => 1
)

 */

?>
