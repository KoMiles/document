<?php
/**
 * 
array_merge() 将一个或多个数组的单元合并起来，一个数组中的值附加在前一个数组的后面。返回作为结果的数组。

如果输入的数组中有相同的字符串键名，则该键名后面的值将覆盖前一个值。然而，如果数组包含数字键名，后面的值将不会覆盖原来的值，而是附加到后面。

如果只给了一个数组并且该数组是数字索引的，则键名会以连续方式重新索引。 
 */

$array1 = array("color" => "red", 2, 4);
$array2 = array("a", "b", "color" => "green", "shape" => "trapezoid", 4);
$result = array_merge($array1, $array2);
print_r($result);

/**
 *
color=>green,
0=>2,
1=>4,
2=>a,
3=>b,
shape=>trapezoid
4=>4
 */

$array1 = array(2);
$array2 = array(1,2,3,4);
$result = array_merge($array1,$array2);
print_r($result);
//强制转换为数组
$array1 = 'st';
$array2 = array(1,2,3,4);
$result = array_merge((array)$array1,$array2);
print_r($result);
?>
