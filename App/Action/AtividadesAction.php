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

			$info = $this->util->getTable('PROJETOS',$INT_PROJ);			

			$vars['INT_PROJ'] = $INT_PROJ;

			$vars['NM_PROJ'] = $info->NM_PROJ;

			$vars['page'] = 'principal';
			
			$vars['include']   = $this->arquivo.'/'.'listagem.php';		
			
			$atividades = $this->obterAtividades($INT_PROJ);			

			$vars['render'] = $this->renderizarAtividades($atividades);

			$response = $this->view->render($response,'index.php',$vars);

			return $response;
		}

		function novo($request,$response){
			
			$vars['INT_PROJ'] = $request->getAttribute('id');
			
			$vars['page'] = 'principal';
			$vars['include'] = $this->arquivo.'/formulario.php';
			$response = $this->view->render($response,'index.php',$vars);
	
			return $response;
			
		}

		function editar($request,$response){
			
			$id = $request->getAttribute('id');
			
			if(!is_numeric($id)){
				return $response->withRedirect(BASEURL);
			}
			
			$dados = $this->util->getTable($this->getTabela(),$id);
			
			/*$dados->D_INI = Funcoes\DataUS2BR($dados->D_INI);
			$dados->D_FIM = Funcoes\DataUS2BR($dados->D_FIM);*/

			$vars['dados'] = $dados;
			$vars['page'] = 'principal';			
			$vars['INT_PROJ'] = $dados->INT_PROJ;	
			$vars['include'] = $this->arquivo.'/formulario.php';
			$response = $this->view->render($response,'index.php',$vars);
	
			return $response;
	
		}

		function delete($request,$response){
		
			$id = $request->getAttribute('id');

			if(!is_numeric($id)){
				return $response->withRedirect(BASEURL);
			}

			//apenas para o redirecinamento correto
			$info = $this->util->getTable($this->getTabela(),$id);

			if($this->util->delete($this->getTabela(),$id) ){
	
				return $response->withRedirect(BASEURL.$this->arquivo.'/'.$info->INT_PROJ);
	
			}else{
	
				$vars['page'] = 'principal';
				$vars['erro'] = $GLOBALS['erro'];
				$vars['include'] = 'erro/erro.php';
				$response = $this->view->render($response,'index.php',$vars);
				return $response;
			}
	
			
			
		}

		function busca($request,$response){
			
			$INT_PROJ = $request->getAttribute('id');

			$info = $this->util->getTable('PROJETOS',$INT_PROJ);

			$vars['INT_PROJ'] = $INT_PROJ;

			$vars['NM_PROJ'] = $info->NM_PROJ;

			$dados =  $this->util->getPosts($request);	
			
			$STR_BUSCA = $_GET['palavra']; // mundo real colocar anti injection

            $vars['include'] = $this->arquivo.'/'.'listagem.php';	
			
			$vars['palavra'] = $STR_BUSCA;

            $atividades = $this->obterAtividades($INT_PROJ, $STR_BUSCA);			

			$vars['page'] = 'principal';
			
            $vars['render'] = $this->renderizarAtividades($atividades);            

			$response = $this->view->render($response,'index.php',$vars);

			return $response;
			
		}

		function salvar($request,$response){
			
			$dados =  $this->util->getPosts($request);

		    if( $INT_PROJ_ATIV = $this->util->save($this->getTabela(),$dados,true)){
                
               return $response->withRedirect(BASEURL.'/atividades/'.$dados['INT_PROJ']);
               
            }else{

                $vars['page'] = 'principal';
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
							<th colspan="2">Finalizado</th>						
						</tr>';
						
			if($atividades){

				while( $L = $atividades->fetchObject()){ 
				
					$RENDER .= '<tr>
									<td>'.$L->NM_ATVD.'</td>
									<td>'.Funcoes\DataUS2BR($L->D_INI).'</td>
									<td>'.Funcoes\DataUS2BR($L->D_FIM).'</td>
									<td>'.$L->LG_FIN.'</td>
									<td>
										<form action="'.BASEURL.'atividades/editar/'.$L->INT_PROJ_ATV.'">	
											<button class="btn btn-warning" >Editar</button>
										</form>
									</td>
									<td>
										<form id="delete" action="'.BASEURL.'atividades/delete/'.$L->INT_PROJ_ATV.'" method="post">
											<button class="btn btn-danger">Excluir</button>
										</form>
									</td>								
								</tr>';
				}

			}

			$RENDER .= '</table>';

			
			return $RENDER;
		}
		
		function obterAtividades($INT_PROJ,$STR_BUSCA = ''){

			$sql = "SELECT * FROM PROJETO_TEM_ATIVIDADE PTA WHERE PTA.INT_PROJ = '$INT_PROJ'";

			if($STR_BUSCA != ''){

				$sql .= " AND ( PTA.NM_ATVD LIKE '%$STR_BUSCA%' || PTA.LG_FIN = '$STR_BUSCA'|| PTA.D_INI = '".Funcoes\DataBR2US($STR_BUSCA)."' || PTA.D_FIM = '".Funcoes\DataBR2US($STR_BUSCA)."' )";
			}	
			
			$R = $this->util->query($sql);

			return $R;
		}

	}
	
?>