<?php
	namespace App\Action;

	//use Util\Classes;

	class Action {

		private $tabela;
		private $container;

		function __construct($container ){
			//print_r($container);exit;
			$this->container = $container;							
			
		}

		function __destruct(){
			
			unset($this->util);

		}

		public function __get($property){
			if($this->container->{$property}){
				return $this->container->{$property};
			}
		}
		
		public function ajax($request,$response){

			$func = $request->getAttribute('func');
			$this->$func($request,$response);
		}

	}

?>
