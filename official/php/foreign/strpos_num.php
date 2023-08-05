<?php

function strpos_num(string $haystack, string $needle, int $num) {
	$offset = 0;
	$length = strlen($needle);
	$pos    = null;

	for ($i = 0; $i < $num; $i++) {
		$pos = strpos($haystack, $needle, $offset);

		// Short circuit continued lookups if we don't find anything
		if ($pos === false) { return false; }

		$offset = $pos + $length;
	}

	return $pos;
}

?>