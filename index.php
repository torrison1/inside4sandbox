<?php
//i--- Error Reporting (Optional) can be in php.ini ; inside_4_core_structure ; torrison ; 01.05.2020 ; 1 ---/
error_reporting( E_ALL );

//i--- Turn Off Cache for Browsers (Optional) can be in php.ini ; inside_4_core_structure ; torrison ; 01.05.2020 ; 2 ---/
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

//i--- Autoloader based on PSR-o Standard ; inside_4_core_structure ; torrison ; 01.05.2020 ; 3 ---/
// https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-0.md

require ('config.php');

function autoload($className)
{
	$className = ltrim($className, '\\');
	$fileName  = '';
	$namespace = '';
	if ($lastNsPos = strrpos($className, '\\')) {
		$namespace = substr($className, 0, $lastNsPos);
		$className = substr($className, $lastNsPos + 1);
		$fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
	}
    $fileName .= $className . '.php';

	// echo $fileName;

	require $fileName;

}
spl_autoload_register('autoload');

//i--- Composer Autoload ; inside_4_core_structure ; torrison ; 01.05.2020 ; 4 ---/
require __DIR__."/Inside4/vendor/autoload.php";

//i--- Class with Globals objects and variables ; inside_4_core_structure ; torrison ; 01.05.2020 ; 5 ---/
$GLOBALS['inside4']['Globals'] = new \Inside4\CommonCore\Globals();
$GLOBALS['inside4']['Globals']->init();

//i--- Easy MVC Routing System Class ; inside_4_core_structure ; torrison ; 01.05.2020 ; 6 ---/
$GLOBALS['inside4']['Routing'] = new \Inside4\CommonCore\Routing();
$GLOBALS['inside4']['Routing']->route();

