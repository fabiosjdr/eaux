<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);

require 'inicializar.php';

require 'App/Routes/routes.php';

$app->run();

?>