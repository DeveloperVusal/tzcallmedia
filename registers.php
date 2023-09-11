<?php

require_once __DIR__.'/vendor/autoload.php';

function app_autoloader($className) {
    $defaultClassName = $className;
	$className = str_replace('\\', '/', $className);
	$dirPath = str_replace('\\', '/', dirname(__FILE__));

	$expl = explode('/', $className);
	$explEnd = end($expl);

	unset($expl[sizeof($expl) - 1]);

	$className = implode('/', array_map(function($val) {
		return strtolower($val);
	}, $expl)).'/'.$explEnd;

	include $dirPath.'/'.$className.'.php';
}

spl_autoload_register('app_autoloader');