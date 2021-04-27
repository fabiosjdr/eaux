<?php
	namespace App\Action;

	use Util;
	use Funcoes;
	use stdclass;

	class Action {

		private $tabela;
		private $container;

		function __construct($container = ''){
			
			if($container == ''){

				require BASEDIR.'inicializar.php';				

				$this->container = $container;			

			}

			$this->container = $container;
		
			$this->util =  new util\Util($container);
			
			$this->stdclass = new stdClass();
			$this->stdclass->Objeto = new stdClass();

			
		}

		function __destruct(){
			
			unset($this->stdclass->Objeto);
			unset($this->util);

		}

		public function __get($property){
			if($this->container->{$property}){
				return $this->container->{$property};
			}
		}
		
        public function getTabela(){
            return $this->tabela;
		}
		
        public function setTabela($tabela){
            return $this->tabela = $tabela;
		}	
		
		
		public function ajax($request,$response){

			$util = new util\Util($this);

			$func = $request->getAttribute('func');

			$this->$func($request,$response);
		}

			

	}
?>
