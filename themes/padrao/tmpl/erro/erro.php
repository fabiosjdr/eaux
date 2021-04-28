 <?php  if(isset($erro)){
		
			$erro_usuario= (isset($erro['mensagem_usuario'] ) )? $erro['mensagem_usuario'] : 'FALHA'; 
				
			echo '<div class="msg_error">
					<div class="py-2 mr-auto ml-auto text-center alert alert-danger">
						<div class="col-lg-12">
							<h2>'.$erro_usuario.'</h2>
		          			<button type="button" class="close" aria-label="Close">
		          				<span aria-hidden="true">&times;</span>
		          			</button>

		          			<button type="button" class="btn btn-info" onclick="exibirDetalhesErro()" >
		          				Detalhes
		          			</button>
	        			</div>
		        		<div class="detalhes oculto">
		    			'.$erro['mensagem_tecnica'].'
		    			</div>
	    			</div>
	    	 	 </div>';
		} 
?>

<div class="col-lg-12 pt-4" align="center">
	<form action="<?=  $_SERVER['HTTP_REFERER'] ?>">
		<input type="submit" class="btn btn-warning"  value="Continuar">
	</form>	
</div>
<script type="text/javascript">

	function exibirDetalhesErro(){
		$('.detalhes').toggleClass('oculto');
	}

</script>
 	
 	