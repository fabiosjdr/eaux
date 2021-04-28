<?php
ini_set('display_errors',0);
ini_set('display_startup_errors', 0);

require 'App/inc/config.php';
require 'vendor/autoload.php';
require 'conteiner.php';

require 'App/Routes/routes.php';

$app->run();

?>