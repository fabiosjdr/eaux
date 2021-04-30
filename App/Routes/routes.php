<?php
  
    
    $app->get("/",'App\Action\ProjetosAction:index');  

    $app->post("/iniciar/ajax/{func}[/[{id}]]",'App\Action\IniciarAction:ajax');

    $app->get("/projetos[/]",'App\Action\ProjetosAction:index');
    $app->get("/projetos/novo[/]",'App\Action\ProjetosViewAction:novo');
    $app->get("/projetos/editar/{id}",'App\Action\ProjetosModelAction:editar')->add(App\Middleware\AuthMiddleware::class);
    $app->post("/projetos/delete/{id}",'App\Action\ProjetosModelAction:delete')->add(App\Middleware\AuthMiddleware::class);
    $app->post("/projetos/salvar[/]",'App\Action\ProjetosModelAction:salvar')->add(App\Middleware\AuthMiddleware::class);  
    $app->get("/projetos/busca/",'App\Action\ProjetosAction:busca')->add(App\Middleware\AuthMiddleware::class);

    $app->get("/atividades/novo/{id}",'App\Action\AtividadesViewAction:novo');
    $app->post("/atividades/salvar[/]",'App\Action\AtividadesModelAction:salvar')->add(App\Middleware\AuthMiddleware::class);
    $app->get("/atividades/editar/{id}",'App\Action\AtividadesModelAction:editar')->add(App\Middleware\AuthMiddleware::class);
    $app->post("/atividades/delete/{id}",'App\Action\AtividadesModelAction:delete')->add(App\Middleware\AuthMiddleware::class);
    $app->get("/atividades/busca/{id}",'App\Action\AtividadesAction:busca')->add(App\Middleware\AuthMiddleware::class);
    $app->get("/atividades/{id}[/]",'App\Action\AtividadesAction:index');
?>