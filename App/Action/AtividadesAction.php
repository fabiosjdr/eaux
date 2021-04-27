<?php

    namespace App\Action;

    use Util;
	use Funcoes;
	
    final class AtividadesAction extends Action{

        private $arquivo = 'atividades';
       
		function __construct($container){

			parent::__construct($container);

			$this->setTabela('PROJETO_TEM_ATIVIDADE');
		}

		function index($request,$response){
						
			$INT_PROJ = $request->getAttribute('id');

			$vars['page'] = 'principal';
			
			$vars['include']   = $this->arquivo.'/'.'listagem.php';		
			
			$atividades = $this->obterAtividades($INT_PROJ);			

			$vars['render'] = $this->renderizarAtividades($atividades);

			$response = $this->view->render($response,'index.php',$vars);

			return $response;
		}

		function novo($request,$response){
			
			
			$vars['page'] = 'principal';
			$vars['include'] = $this->arquivo.'/formulario.php';
			$response = $this->view->render($response,'index.php',$vars);
	
			return $response;
			
		}

		function editar($request,$response){
			
			$id = $request->getAttribute('id');
			
			if(!is_numeric($id)){

				$vars['page'] = '404';
				$response = $this->container['view']->render($response,'index.php',$vars);
				return $response;
				//return $response->withRedirect(BASEURL);
			}
			
			$dados = $this->util->getTable($this->getTabela(),$id);
			
			/*$dados->D_INI = Funcoes\DataUS2BR($dados->D_INI);
			$dados->D_FIM = Funcoes\DataUS2BR($dados->D_FIM);*/

			$vars['dados'] = $dados;
			$vars['page'] = 'principal';			
			
			$vars['include'] = $this->arquivo.'/formulario.php';
			$response = $this->view->render($response,'index.php',$vars);
	
			return $response;
	
		}

		function delete($request,$response){
		
			$id = $request->getAttribute('id');
	
			if(!is_numeric($id)){
				$vars['page'] = '404';
				$response = $this->container['view']->render($response,'index.php',$vars);
				return $response;
				//return $response->withRedirect(BASEURL);
			}
	
			$util = new util\Util($this);
	
			if($util->delete($this->getTabela(),$id) ){
	
				return $response->withRedirect(BASEURL.$this->arquivo);
	
			}else{
	
				$vars['page'] = 'painel';
				$vars['erro'] = $GLOBALS['erro'];
				$vars['include'] = 'erro/erro.php';
				$response = $this->view->render($response,'index.php',$vars);
				return $response;
			}
	
			
			
		}

		function busca($request,$response){
			
			$dados =  $this->util->getPosts($request);	
			

			$vars['pagina'] = filter_var($request->getAttribute('pagina'),FILTER_SANITIZE_NUMBER_INT);			

            $vars['INT_TP_BUSC'] = $_GET['INT_TP_BUSC'];
			$vars['STR_BUSCA'] = $_GET['STR_BUSCA'];			

            $vars['include'] = $this->arquivo.'/'.'listagem.php';	

            $documentacao = $this->obterProcessos($vars);			

			if($this->CONTA != ''){
				$vars['page'] = 'painel';
			}else{
				$vars['page'] = 'principal';
			}

            $vars['render'] = $this->renderizarListagem($documentacao);            

			$response = $this->view->render($response,'index.php',$vars);

			return $response;
			
		}
		
    	function salvar($request,$response){
			
			$dados =  $this->util->getPosts($request);

			/*$dados['D_INI'] = Funcoes\DataBR2US($dados['D_INI']);
			$dados['D_FIM'] = Funcoes\DataBR2US($dados['D_FIM']);*/
            
            if( $INT_PROJ = $this->util->save($this->getTabela(),$dados,true)){
                
               return $response->withRedirect(BASEURL);
               
            }else{

                $vars['page'] = 'painel';
                $vars['erro'] = $GLOBALS['erro'];
                $vars['include'] = 'erro/erro.php';
                $response = $this->view->render($response,'index.php',$vars);
                return $response;

            }
		}

		function renderizarAtividades($atividades){

			$RENDER = '<table class="table table-striped">
						<tr>
							<th>Nome da atividade</th>
							<th>Data de início</th>
							<th>Data de término</th>
							<th>Finalizado</th>							
						</tr>';
						
			if($atividades){

				while( $L = $atividades->fetchObject()){ 
				
					$RENDER .= '<tr>
									<td>'.$L->NM_ATVD.'</td>
									<td>'.Funcoes\DataUS2BR($L->D_INI).'</td>
									<td>'.Funcoes\DataUS2BR($L->D_FIM).'</td>
									<td>'.$L->LG_FIN.'</td>
									<td>
										<form action="'.BASEURL.'projetos/editar/'.$L->INT_PROJ.'">	
											<button class="btn btn-warning" >Editar</button>
										</form>
									</td>
									<td>
										<form id="delete" action="'.BASEURL.'projetos/delete/'.$L->INT_PROJ.'" method="post">
											<button class="btn btn-danger">Excluir</button>
										</form>
									</td>								
								</tr>';
				}

			}

			$RENDER .= '</table>';

			
			return $RENDER;
		}
		
		function obterAtividades($INT_PROJ){

			$R = $this->util->query("SELECT * FROM PROJETO_TEM_ATIVIDADE WHERE INT_PROJ = '$INT_PROJ'");

			return $R;
		}

	}
	
?>