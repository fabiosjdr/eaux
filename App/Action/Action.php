<?php
	namespace App\Action;

	use Util;
	use Funcoes;

	class Action {

		private $tabela;
		private $container;

		function __construct($container){
			
			$this->container = $container;		
			$this->util =  new util\Util($container);			
			$this->util->testConnection();

		}

		function __destruct(){
			
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

			$func = $request->getAttribute('func');

			$this->$func($request,$response);
		}

		

			

	}
?>
