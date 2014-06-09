<?php
	$x = array('a' => 1, 'b' => 2, '0' => 3);
	$y = array(0 => $x, 1 => 'x');
	var_dump(isAssoc($x));
	var_dump(isAssoc($y));
	var_dump(array_keys($y));
	//var_dump(count($x));
	//var_dump(array_key_exists(0, $x));
	
	function isAssoc($arr)
{
    return array_keys($arr) !== range(0, count($arr) - 1);
}
?>