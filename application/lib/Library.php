<?php

/**
 * 配列かどうかを調べ、配列でなければ配列にする
 * @param mixed $var
 * @return array $result
 */
function changeArray( $var ) {
	
	if ( is_array( $var ) === FALSE ) {
		$result = array( $var );
	} else {
		$result = $var;
	}
	return $result;
}