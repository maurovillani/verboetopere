<?php

/**
 * Helper class to work with string
 */

// check whether a string starts with the target substring
function starts_with($haystack, $needle)
{
	return substr($haystack, 0, strlen($needle))===$needle;
}

// check whether a string ends with the target substring
function ends_with($haystack, $needle)
{
	return substr($haystack, -strlen($needle))===$needle;
}
/**
 * Get string between two substrings
 *
 * @param string $string
 * @param string $start
 * @param string $end
 * @return string text between two substrings
 */
function get_string_between($string, $start, $end)
{
	$string = ' ' . $string;
	$ini = strpos($string, $start);
	if ($ini == 0) return '';
	$ini += strlen($start);
	$len = strpos($string, $end, $ini) - $ini;
	return substr($string, $ini, $len);
}

function myArraySortFunction($a, $b)
{
  return strnatcmp($a, $b);
}

/**
 * Undocumented function
 *	@author  Paolo Minervino <paolo.minervino@ecm2.it>
 * @param [type] $arrayToSort array of associatives array
 * @param [type] $field of array to order
 * @return void
 */
function myArrayASortFunction(&$arrayToSort, $field) {
    uasort($arrayToSort, function($a, $b) use ($field) {
        return strnatcmp($a[$field], $b[$field]);
    });
}