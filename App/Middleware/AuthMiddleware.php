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
			
			
			Funcoes\buildConteinerAction($this->container,'projetos');
			$response = $next($request, $response);
	        return $response;
		}

		public function buildAtividades($request, $response, $next){
			
			
			Funcoes\buildConteinerAction($this->container,'atividades');
			$response = $next($request, $response);
	        return $response;
		}

	
		
	}
?>