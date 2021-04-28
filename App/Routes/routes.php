<?php
  
    $app->get("/",'App\Action\ProjetosAction:index');  

    $app->post("/iniciar/ajax/{func}[/[{id}]]",'App\Action\IniciarAction:ajax')->add(App\Middleware\AuthMiddleware::class);

    $app->get("/projetos[/]",'App\Action\ProjetosAction:index');
    $app->get("/projetos/novo[/]",'App\Action\ProjetosAction:novo');
    $app->get("/projetos/editar/{id}",'App\Action\ProjetosAction:editar')->add(App\Middleware\AuthMiddleware::class);
    $app->post("/projetos/delete/{id}",'App\Action\ProjetosAction:delete')->add(App\Middleware\AuthMiddleware::class);
    $app->post("/projetos/salvar[/]",'App\Action\ProjetosAction:salvar')->add(App\Middleware\AuthMiddleware::class);  
    $app->get("/projetos/busca/",'App\Action\ProjetosAction:busca')->add(App\Middleware\AuthMiddleware::class);



    $app->get("/atividades/novo/{id}",'App\Action\AtividadesAction:novo');
    $app->post("/atividades/salvar[/]",'App\Action\AtividadesAction:salvar')->add(App\Middleware\AuthMiddleware::class);
    $app->get("/atividades/editar/{id}",'App\Action\AtividadesAction:editar')->add(App\Middleware\AuthMiddleware::class);
    $app->post("/atividades/delete/{id}",'App\Action\AtividadesAction:delete')->add(App\Middleware\AuthMiddleware::class);
    $app->get("/atividades/busca/{id}",'App\Action\AtividadesAction:busca')->add(App\Middleware\AuthMiddleware::class);
    $app->get("/atividades/{id}[/]",'App\Action\AtividadesAction:index');
?>