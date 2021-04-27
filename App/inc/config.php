<?php

	
	define('HTTP','http://'); //somente alterar esses valores
	define('BASEFILES',basename(realpath(__DIR__.'/../..') ) ); 
	define('THEME', 'padrao'); 
	

	define('BASEURL',HTTP.$_SERVER['SERVER_NAME'].'/'.BASEFILES.'/');
	define('THEMEPATH',$_SERVER['DOCUMENT_ROOT'].BASEFILES.'/themes/'.THEME);
	define('BASEPATH',$_SERVER['DOCUMENT_ROOT'].BASEFILES);
	define('THEMEURL', BASEURL.'/themes/'.THEME);

	$configfile = __DIR__.'/config.json';
	$DBCONF = (file_exists($configfile)) ? json_decode(file_get_contents($configfile),true) : '';
	
	//$APP_DIR = THEMEPATH;

	$config = [
		'settings' => [
			'displayErrorDetails' => false,        
			'db' => $DBCONF
		],
	];

?>
