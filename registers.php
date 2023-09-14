<?php
require_once __DIR__.'/vendor/autoload.php';

function app_autoloader($className) {
	$className = str_replace('\\', '/', $className);
	$dirPath = str_replace('\\', '/', __DIR__);

	$expl = explode('/', $className);
	$explEnd = end($expl);

	unset($expl[sizeof($expl) - 1]);

	$className = implode('/', array_map(function($val) {
		return strtolower($val);
	}, $expl)).'/'.$explEnd;

	include $dirPath.'/'.$className.'.php';
}

spl_autoload_register('app_autoloader');

$envFile = __DIR__.'/.env';

if (is_file($envFile)) {
	$lines = file($envFile, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

	foreach ($lines as $line) {
		if (strpos(trim($line), '#') === 0) continue;

		list($name, $value) = explode('=', $line, 2);
		
		$name = trim($name);
		$value = trim($value);

		if (!array_key_exists($name, $_SERVER) && !array_key_exists($name, $_ENV)) {
			putenv(sprintf('%s=%s', $name, $value));
			$_ENV[$name] = $value;
			$_SERVER[$name] = $value;
		}
	}
}