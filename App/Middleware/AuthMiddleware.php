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
			
			$this->container['modelAction'] = new Action\ProjetosModelAction($this->container);
			$this->container['viewAction']  = new Action\ProjetosViewAction($this->container);			
			$this->container['tabela']	 	= new Util\Classes\TabelaDaClasse('PROJETOS');

			$response = $next($request, $response);
	        return $response;
		}

		public function buildAtividades($request, $response, $next){
			
			$this->container['modelAction'] = new Action\AtividadesModelAction($this->container);
			$this->container['viewAction']  = new Action\AtividadesViewAction($this->container);			
			$this->container['tabela']	 	= new Util\Classes\TabelaDaClasse('PROJETO_TEM_ATIVIDADE');

			$response = $next($request, $response);
	        return $response;
		}

	
		
	}
?>