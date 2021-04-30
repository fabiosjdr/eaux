<?php 
	namespace App\Middleware;
	use Funcoes;
	use Util;
	use App\Action;
	class AuthMiddleware{

		private $container;

	    public function __construct($container) {
			
	        $this->container = $container;
	    }

		public function __invoke($request, $response, $next){
			
			$response = $next($request, $response);
			return $response;			
	        
	    }

		public function buildProjeto($request, $response, $next){
			
			//$this->container->modelAction = new Action\ProjetosModelAction($this);
			//$this->container->viewAction  = new Action\ProjetosViewAction($this);
			

			$response = $next($request, $response);
	        return $response;
		}

		

	
		
	}
?>