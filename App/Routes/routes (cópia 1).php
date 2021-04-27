<?php
    //echo $_SERVER['REQUEST_URI'].'-->'.BASEURL;exit;
    $url = $_SERVER['REQUEST_URI'];
    

    if(BASEFILES != '/'){
      $url = str_replace(BASEFILES, '', $url);  
    }
    
   
    $url = explode('/', preg_replace('/\/+\//i', '/', $url));
    
    if(isset($url[1]) && $url[1] != ''){ 
      
      $objeto = explode('?', $url[1]);      
      $objeto = ($objeto[0] != '') ? $objeto[0] : null ;  

    }else{
     
      $objeto = null;
    }
    
    if(isset($url[2]) && $url[1] != ''){ 

      $acao = explode('?', $url[2]);      
      $acao = ($acao[0] != '') ? $acao[0] : null ;  

    }else{
    	
      $acao = null;
    }
  
    // print_r($url).'---'. $objeto.'---'.$acao;exit;
    if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    
        
      if($objeto == 'login' && $acao != 'ajax'){

         $app->post('/login','App\\Action\LoginAction:login');
      }else if($objeto == 'api' && isset($acao)){

           $app->post('/'.$objeto.'/'.$acao.'[/{id}]','App\\Action\\'.ucfirst($objeto).'Action:'.$acao)->add(App\Middleware\AuthMiddleware::class .':api');
      }else if($objeto == 'home' && isset($acao) && $acao != 'ajax' ){
 
           $app->post('/'.$objeto.'/'.$acao.'[/[{id}]]','App\\Action\\'.ucfirst($objeto).'Action:'.$acao);
      }else if($acao == 'salvar'){

        $app->post("/$objeto/salvar",'App\\Action\\'.ucfirst($objeto).'Action:salvar')->add(App\Middleware\AuthMiddleware::class);
      }else if($acao == 'delete'){

        $app->post("/$objeto/delete/{id}[/[{subid}]]",'App\\Action\\'.ucfirst($objeto).'Action:delete')->add(App\Middleware\AuthMiddleware::class);
      }else if($acao == 'ajax'){
      
         $app->post("/$objeto/ajax/{func}",'App\\Action\\'.ucfirst($objeto).'Action:ajax')->add(App\Middleware\AuthMiddleware::class);
      }else{
         
        if(file_exists($_SERVER['DOCUMENT_ROOT'].BASEFILES.'/App/Action/'.ucfirst($objeto).'Action.php')){

           $app->post("/".$objeto."[/]",'App\\Action\\'.ucfirst($objeto).'Action:index')->add(App\Middleware\AuthMiddleware::class);

        }else{

          $app->post("/".$objeto.'[/[{id}]]','App\\Action\\HomeAction:'.$objeto);
        }
      }

      

    }else{
  
      if(!isset($objeto)){  
       
          if(isset($_SESSION[PREFIX.'logado']) && $_SESSION[PREFIX.'logado']){

            switch($_SESSION[PREFIX.'tipo']){
              case 1: $app->get('/','App\\Action\ProcessosAction:index');
              break;
              case 2: $app->get('/','App\\Action\ContaAction:convite');
              break;
              case 3: $app->get('/','App\\Action\ProcessosAction:index');
              break; 
            }

          }else{

            $app->get('/','App\\Action\HomeAction:index');

          }

      }else if(isset($objeto)){

        if($objeto == 'login' && !isset($acao)){   
         
          $app->get('/login','App\\Action\LoginAction:index')->add(App\Middleware\AuthMiddleware::class .':login');
        
        }else if ($objeto == 'logout'){
          
          $app->get('/logout','App\\Action\LoginAction:logout');
          
        }else if($objeto == 'api' && isset($acao)){

           $app->get('/'.$objeto.'/'.$acao.'[/{id}]','App\\Action\\'.ucfirst($objeto).'Action:'.$acao)->add(App\Middleware\AuthMiddleware::class .':api');
        
        }else if ($objeto == 'api'){
         
          $app->get('/api','App\\Action\ApiAction:index')->add(App\Middleware\AuthMiddleware::class .':api');
          
        }else if($objeto == 'relatorios' && isset($acao)){
  
           if(is_numeric($acao)){
           
            $app->get("/$objeto/{id}[/]",'App\\Action\\'.ucfirst($objeto).'Action:dinamico')->add(App\Middleware\AuthMiddleware::class);
           
           }else{
              
              $app->get("/$objeto/".$acao.'[/]','App\\Action\\'.ucfirst($objeto).'Action:'.$acao)->add(App\Middleware\AuthMiddleware::class); 
           }
             
        }else{ 
            
          
            if(file_exists($_SERVER['DOCUMENT_ROOT'].BASEFILES.'/App/Action/'.ucfirst($objeto).'Action.php')){

              if($acao == 'pass'){

                $app->get("/$objeto/pass/{hash}[/[{subid}]]",'App\\Action\\'.ucfirst($objeto).'Action:linkExterno')->add(App\Middleware\AuthMiddleware::class);

              }elseif($acao == 'pagina'){
                
                 $app->get("/$objeto/pagina/{pagina}[/[{subid}]]",'App\\Action\\'.ucfirst($objeto).'Action:busca')->add(App\Middleware\AuthMiddleware::class);

              }else if($acao == 'novo'){
               
                $app->get("/$objeto/novo[/[{id}]]",'App\\Action\\'.ucfirst($objeto).'Action:novo')->add(App\Middleware\AuthMiddleware::class);
              
              }else if($acao == 'edit'){ 
                
                 $app->get("/$objeto/edit/{id}[/[{subid}]]",'App\\Action\\'.ucfirst($objeto).'Action:editar')->add(App\Middleware\AuthMiddleware::class);

              }else if($acao == 'busca'){ 
          
                $app->get("/$objeto/busca/",'App\\Action\\'.ucfirst($objeto).'Action:busca')->add(App\Middleware\AuthMiddleware::class);
              
              }else if($acao == 'ajax'){
                  
                 $app->get("/$objeto/ajax/{func}[/[{id}]]",'App\\Action\\'.ucfirst($objeto).'Action:ajax')->add(App\Middleware\AuthMiddleware::class);

              }else if(is_numeric($acao)){ 

                  $app->get("/$objeto/{id}",'App\\Action\\'.ucfirst($objeto).'Action:index')->add(App\Middleware\AuthMiddleware::class); 
              
              }else if( method_exists('App\\Action\\'.ucfirst($objeto).'Action',$acao) ){

                //$app->get("/".$objeto.'/'.$acao.'[/[{id}]]','App\\Action\\'.ucfirst($objeto).'Action:'.$acao)->add(App\Middleware\AuthMiddleware::class .':validaAcesso'); // validar origem acesso
                $app->get("/".$objeto.'/'.$acao.'[/[{id}]]','App\\Action\\'.ucfirst($objeto).'Action:'.$acao)->add(App\Middleware\AuthMiddleware::class);

              }else{

                 $app->get("/".$objeto."[/]",'App\\Action\\'.ucfirst($objeto).'Action:index')->add(App\Middleware\AuthMiddleware::class);
              }

             
            
            }else if($acao == 'pagina'){
            
              $app->get('/'.$objeto.'/pagina/{id}[/[{subid}]]','App\\Action\\HomeAction:'.$objeto); 

            }else if($objeto == 'detalhes'){

               $app->get("/".$objeto.'[/[{id}]]','App\\Action\\HomeAction:'.$objeto);

            }else if( method_exists('App\\Action\\HomeAction',$objeto) ){
                
                $app->get("/".$objeto.'[/[{id}]]','App\\Action\\HomeAction:'.$objeto);
                
            }else{
  
                $app->get("/$objeto",'App\\Action\\LandingpageAction:verificar'); 
                //$app->get('/'.$objeto.'[/[{id}]]','App\\Action\\HomeAction:'.$objeto); 
             
            }
            
              
        }        
          
      }

      
      
    }

    
    
    
    

 
  
?>