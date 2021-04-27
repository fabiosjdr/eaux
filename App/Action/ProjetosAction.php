<?php

    namespace App\Action;

    use Util;
	use Funcoes;
	
    final class ProjetosAction extends Action{

        private $arquivo = 'projetos';
       
		function __construct($container){

			parent::__construct($container);

			$this->setTabela('PROJETOS');
		}

		function getProjetos(){
			return $this->stdclass;
		}

		function index($request,$response){
			
			
			$vars['page'] = 'principal';
			
			$vars['include']   = $this->arquivo.'/'.'listagem.php';		
			
			$projetos = $this->obterProjetos();			

			$vars['render'] = $this->renderizarProjetos($projetos);

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

		function renderizarProjetos($projetos){

			$RENDER = '<table class="table table-striped">
						<tr>
							<th>Nome do projeto</th>
							<th>Data de início</th>
							<th>Data de término</th>
							<th>% Completo</th>
							<th>Atrasado</th>
							<th colspan="3"></th>
						</tr>';
						
			if($projetos){

				while( $L = $projetos->fetchObject()){ 
				
					$RENDER .= '<tr>
									<td>'.$L->NM_PROJ.'</td>
									<td>'.Funcoes\DataUS2BR($L->D_INI).'</td>
									<td>'.Funcoes\DataUS2BR($L->D_FIM).'</td>
									<td>0 %</td>
									<td>N</td>	
									<td>
										<form action="atividades/'.$L->INT_PROJ.'">	
											<button class="btn btn-success" >Ver atividades</button>
										</form>
									</td>
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
		
		function obterProjetos(){

			$R = $this->util->query("SELECT * FROM PROJETOS");

			return $R;
		}

	}
	
?>