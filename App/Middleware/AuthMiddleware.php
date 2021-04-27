<?php 
	namespace App\Middleware;
	use Funcoes;

	class AuthMiddleware{

		private $container;

	    public function __construct($container) {
	        $this->container = $container;
	    }

		public function __invoke($request, $response, $next){
			
			//aqui podemos tratar sessao, login etc
			if(1==1){

				$response = $next($request, $response);
	        	return $response;
			}
	        
	    }

	
		
	}
?>