<?php
    
    $app = new \Slim\App($config);
    $container = $app->getContainer();

    $container['view'] = new \Slim\Views\PhpRenderer('themes/'.THEME);
    
    //conecta o banco que quiser
    $container['db'] = function ($c){
        
        $db = $c['settings']['db'];
        //echo $db['dbname'];exit;
        $pdo = new PDO('mysql:host=' . $db['host'] . ';dbname=' . $db['dbname'].';charset=utf8', $db['user'], $db['pass']);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        

        return $pdo;

    };

    //aqui apenas redireciona para 404 quando nao encontra a rota
    $container['errorHandler'] = function ($c) { 
        
        return function ($request, $response, $exception) use ($c) {
        
            $vars['page'] = '404';
            $response = $c['view']->render($response,'index.php',$vars);
            return $response;
        
        };
    };
    

?>