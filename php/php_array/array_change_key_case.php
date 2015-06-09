<?php
/**
 *  array_change_key_case — 返回字符串键名全为小写或大写的数组
 *  将数组的下标全部转换为大写或者小写
 *  array array_change_key_case ( array $input [, int $case = CASE_LOWER ] )
 *  input 需要操作的数组
 *  case  可以在这里用两个常量，CASE_UPPER 或 CASE_LOWER（默认值）。
 */
$input_array = array("FirSt" => 1, "SecOnd" => 4);
print_r(array_change_key_case($input_array, CASE_UPPER));
echo "\n";
print_r(array_change_key_case($input_array));
?>
