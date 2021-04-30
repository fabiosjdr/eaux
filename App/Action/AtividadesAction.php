<?php

    namespace App\Action;
	
    class AtividadesAction extends Action{

		private $modelAction;
		private $viewAction;
       
		function __construct($container){

			parent::__construct($container);

			$this->modelAction = new AtividadesModelAction($container);
			$this->viewAction = new AtividadesViewAction($container);
		}

		function index($request,$response){
						
			$INT_PROJ = $request->getAttribute('id');

			$info = $this->util->getTable('PROJETOS',$INT_PROJ);			

			$vars['INT_PROJ'] = $INT_PROJ;

			$vars['NM_PROJ'] = $info->NM_PROJ;

			$vars['page'] = 'principal';
			
			$vars['include']   = 'atividades/listagem.php';		
			
			$atividades = $this->modelAction->obter($INT_PROJ);			

			$vars['render'] = $this->viewAction->renderizar($atividades);

			$response = $this->view->render($response,'index.php',$vars);

			return $response;
		}

		function busca($request,$response){
			
			$INT_PROJ = $request->getAttribute('id');

			$info = $this->util->getTable('PROJETOS',$INT_PROJ);

			$vars['INT_PROJ'] = $INT_PROJ;

			$vars['NM_PROJ'] = $info->NM_PROJ;

			$dados =  $this->util->getPosts($request);	
			
			$STR_BUSCA = $_GET['palavra']; // mundo real colocar anti injection

            $vars['include'] = 'atividades/listagem.php';	
			
			$vars['palavra'] = $STR_BUSCA;

            $atividades = $this->modelAction->obter($INT_PROJ, $STR_BUSCA);			

			$vars['page'] = 'principal';
			
            $vars['render'] = $this->viewAction->renderizar($atividades);            

			$response = $this->view->render($response,'index.php',$vars);

			return $response;
			
		}
		
	}	
	
?>