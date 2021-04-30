<?php
	namespace App\Action;

	class ProjetosAction extends Action{

        
		private $modelAction;
		private $viewAction;
		
		function __construct($container){

			parent::__construct($container);
			
			$this->modelAction = new ProjetosModelAction($container);
			$this->viewAction = new ProjetosViewAction($container);

		}

		function index($request, $response){
			
			$vars['page'] = 'principal';
			
			$vars['include']   = 'projetos/listagem.php';		
			
			$projetos = $this->modelAction->obter();			

			$vars['render'] = $this->viewAction->renderizar($projetos);

			$response = $this->view->render($response,'index.php',$vars);

			return $response;
		}

		function busca($request,$response){
			
			$dados =  $this->util->getPosts($request);	
			
			$STR_BUSCA = $_GET['palavra']; // mundo real colocar anti injection

            $vars['include'] = 'projetos/listagem.php';	
			
			$vars['palavra'] = $STR_BUSCA;

            $projetos = $this->modelAction->obter($STR_BUSCA);			

			$vars['page'] = 'principal';
			
            $vars['render'] = $this->viewAction->renderizar($projetos);            

			$response = $this->view->render($response,'index.php',$vars);

			return $response;
			
		}

	}
	
?>