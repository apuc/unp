<?php

if (!function_exists('parse')) {
	/**
	 *
	 *
	 */
	function parse($str, $variables)
	{
		foreach ($variables as $variable => $value)
			$str = preg_replace('/\%' . $variable . '/i', $value, $str);

		return $str;
	}
}