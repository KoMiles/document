<?php
//array_diff — 计算数组的差集
//对比返回在 array1 中但是不在 array2 及任何其它参数数组中的值。
<?php
$array1 = array("a" => "green", "red", "blue", "red");
$array2 = array("b" => "green", "yellow", "red");
$result = array_diff($array1, $array2);

print_r($result);
/**
 *Array
(
    [1] => blue
)
 */
?>

