<?php
	
	namespace Funcoes;
	
	
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

	function primeiroAcesso(){
		
		echo '<script>alert("teste")</script>';
	}
?>
