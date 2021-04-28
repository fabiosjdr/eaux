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
	
			if($this->util->delete($this->getTabela(),$id) ){
	
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
			
			$STR_BUSCA = $_GET['palavra']; // mundo real colocar anti injection

            $vars['include'] = $this->arquivo.'/'.'listagem.php';	
			
			$vars['palavra'] = $STR_BUSCA;

            $projetos = $this->obterProjetos($STR_BUSCA);			

			$vars['page'] = 'principal';
			
            $vars['render'] = $this->renderizarProjetos($projetos);            

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

					$ATRASO = ($L->ATRASO == 'S') ?"<span class='btn btn-danger btn-sm'> Sim </span> " : "<span class='btn btn-success btn-sm'> Não </span> ";
					$PORC = ($L->PORCENTO == '') ? '0.00' : $L->PORCENTO;
					$RENDER .= '<tr>
									<td>'.$L->NM_PROJ.'</td>
									<td>'.Funcoes\DataUS2BR($L->D_INI).'</td>
									<td>'.Funcoes\DataUS2BR($L->D_FIM).'</td>
									<td>'.$PORC.' %</td>
									<td>'.$ATRASO.'</td>	
									<td>
										<form action="atividades/'.$L->INT_PROJ.'">	
											<button class="btn btn-info" >Ver atividades</button>
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
		
		function obterProjetos($STR_BUSCA =  ''){

			$sql = "SELECT 
					*,
					ROUND((
						(
							SELECT COUNT(INT_PROJ_ATV) 
							FROM PROJETO_TEM_ATIVIDADE 
							WHERE INT_PROJ = P.INT_PROJ AND LG_FIN = 'S'
						) * 100
					  ) / 
					  (
							SELECT COUNT(INT_PROJ_ATV) 
							FROM PROJETO_TEM_ATIVIDADE 
							WHERE INT_PROJ = P.INT_PROJ
					   )
					,2) AS PORCENTO,
					IF ((
							SELECT MAX(D_FIM) 
							FROM PROJETO_TEM_ATIVIDADE 
							WHERE INT_PROJ = P.INT_PROJ
						) > P.D_FIM, 'S','N'
					) AS ATRASO 
				FROM
					PROJETOS P";

			if($STR_BUSCA != ''){

				$sql .= " WHERE P.NM_PROJ LIKE '%$STR_BUSCA%' || P.D_INI = '".Funcoes\DataBR2US($STR_BUSCA)."' || P.D_FIM = '".Funcoes\DataBR2US($STR_BUSCA)."' ";
			}		
			//echo $sql;exit;
			$R = $this->util->query($sql);

			return $R;
		}

	}
	
?>