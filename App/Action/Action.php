<?php
	namespace App\Action;

	use Util;
	use Util\Classes;

	class Action extends Classes\Ajax {

		private $tabela;
		private $container;

		function __construct($container ){
			
			$this->container = $container;		
			$this->util =  new Util\Util($container);	
			$this->util->testConnection($container);

		}

		function __destruct(){
			
			unset($this->util);

		}

		public function __get($property){
			if($this->container->{$property}){
				return $this->container->{$property};
			}
		}
		

	}

?>
