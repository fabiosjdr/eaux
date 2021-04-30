<?php
ini_set('display_errors',1);
ini_set('display_startup_errors', 1);

require 'vendor/autoload.php';

require 'App/inc/config.php';

require 'App/interfaces/interfaces.php';

require 'conteiner.php';

require 'App/Routes/routes.php';

$app->run();

?>