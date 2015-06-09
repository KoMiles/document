<?php
//array_key_exists — 检查给定的键名或索引是否存在于数组中
//array_key_exists() 在给定的 key 存在于数组中时返回 TRUE。key 可以是任何能作为数组索引的值。array_key_exists() 也可用于对象。
$search_array = array('first' => 1, 'second' => 4);
if (array_key_exists('first', $search_array)) {
    echo "The 'first' element is in the array";
}

echo "\n";
$search_array = array('first' => null, 'second' => 4);

// returns false
$re = isset($search_array['first']);
echo "\n";
var_dump($re);

// returns true
$re = array_key_exists('first', $search_array);
echo "\n";
var_dump($re);
?>

