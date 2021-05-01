<?php
	
	namespace Funcoes;
	
	use App\Action;
	use Util;
	/* se precisar de funcões inserir aqui*/

	function DataBR2US($D){
		
		if($D == "")	
			return "";
		
		$v = explode("/", $D);

		if(sizeOf($v) == 3){
			$Data = $v[2] . "-" . $v[1] . "-" . $v[0];
			return $Data;
		}else{
			return false;
		}  

	}

	function DataUS2BR($D){
		if($D == "")	
		  return "";
  
		$v = explode("-", $D);
		if(sizeOf($v)==3){
		  $Data = $v[2] . "/" . $v[1] . "/" . $v[0];
		  return $Data;
		}else{
		  return false;
		}  
	
	}

	function buildConteinerAction($container,$actionClass){
		
		if($actionClass == 'projetos'){

			$container['modelAction'] = new Action\ProjetosModelAction($container);
			$container['viewAction']  = new Action\ProjetosViewAction($container);			
			$container['tabela']	  = new Util\Classes\TabelaDaClasse('PROJETOS');

		}else{

			$container['modelAction'] = new Action\AtividadesModelAction($container);
			$container['viewAction']  = new Action\AtividadesViewAction($container);			
			$container['tabela']	  = new Util\Classes\TabelaDaClasse('PROJETO_TEM_ATIVIDADE');
		}
		
		return $container;
	}
?>
