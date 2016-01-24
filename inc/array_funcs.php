<?php

function array_avg($array) {
	$r = 0;
	$nb = 0;
	foreach ($array as $value) {
		if (is_nan($value)) { continue; }

		$r += $value;
		$nb++;
	}

	if ($nb == 0) { return NAN; };

	return ($r / $nb);
}

function array_max($array) {
	$r = $array[0];
	foreach ($array as $value) {
		if (is_nan($value)) { continue; }

		if ($value > $r) {
			$r = $value;
		}
	}

	return $r;
}

function array_min($array) {
	$r = $array[0];
	foreach ($array as $value) {
		if (is_nan($value)) { continue; }

		if ($value < $r) {
			$r = $value;
		}
	}

	return $r;
}
