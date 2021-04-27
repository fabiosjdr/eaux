<?php

	
	define('HTTP','http://'); //somente alterar esses valores
	define('BASEFILES',basename(realpath(__DIR__.'/../..') ) ); 
	define('THEME', 'padrao'); 
	

	define('BASEURL',HTTP.$_SERVER['SERVER_NAME'].'/'.BASEFILES.'/');
	define('THEMEPATH',$_SERVER['DOCUMENT_ROOT'].BASEFILES.'/themes/'.THEME);
	define('THEMEURL', BASEURL.'/themes/'.THEME);

	$APP_DIR = THEMEPATH;

	$config = [
		'settings' => [
			'displayErrorDetails' => false,        
			'db' => [
				'host' => 'localhost',
				'user' => 'root',
				'pass' => 'root',
				'dbname' => 'projetos',
			]
		],
	];

?>
