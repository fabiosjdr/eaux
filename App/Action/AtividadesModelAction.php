<?php

    namespace App\Action;
    
    use App\Interfaces;
    use Util\Classes;
	use Funcoes;

    class AtividadesModelAction extends Action implements Interfaces\ActionModel{
        
        function __construct($container){

            parent::__construct($container);
            $this->tabela = new Classes\SetTabela('PROJETO_TEM_ATIVIDADE');
            
        }

       
        function editar($request,$response){
            
            $id = $request->getAttribute('id');
            
            if(!is_numeric($id)){
                return $response->withRedirect(BASEURL);
            }
            
            $dados = $this->util->getTable($this->tabela->getNomeTabela(),$id);
            
            $vars['dados'] = $dados;
            $vars['page'] = 'principal';			
            $vars['INT_PROJ'] = $dados->INT_PROJ;	
            $vars['include'] = 'atividades/formulario.php';
            $response = $this->view->render($response,'index.php',$vars);

            return $response;

        }

        function delete($request,$response){

            $id = $request->getAttribute('id');

            if(!is_numeric($id)){
                return $response->withRedirect(BASEURL);
            }

            //apenas para o redirecinamento correto
            $info = $this->util->getTable($this->tabela->getNomeTabela(),$id);

            if($this->util->delete($this->tabela->getNomeTabela(),$id) ){

                return $response->withRedirect(BASEURL.'atividades/'.$info->INT_PROJ);

            }else{

                $vars['page'] = 'principal';
                $vars['erro'] = $GLOBALS['erro'];
                $vars['include'] = 'erro/erro.php';
                $response = $this->view->render($response,'index.php',$vars);
                return $response;
            }

            
            
        }

        function salvar($request,$response){
            
            $dados =  $this->util->getPosts($request);

            if( $INT_PROJ_ATIV = $this->util->save($this->tabela->getNomeTabela(),$dados,true)){
                
                return $response->withRedirect(BASEURL.'/atividades/'.$dados['INT_PROJ']);
            
            }else{

                $vars['page'] = 'principal';
                $vars['erro'] = $GLOBALS['erro'];
                $vars['include'] = 'erro/erro.php';
                $response = $this->view->render($response,'index.php',$vars);
                return $response;

            }
        }

        function obter($INT_PROJ,$STR_BUSCA = ''){

            $sql = "SELECT * FROM PROJETO_TEM_ATIVIDADE PTA WHERE PTA.INT_PROJ = '$INT_PROJ'";

            if($STR_BUSCA != ''){

                $sql .= " AND ( PTA.NM_ATVD LIKE '%$STR_BUSCA%' || PTA.LG_FIN = '$STR_BUSCA'|| PTA.D_INI = '".Funcoes\DataBR2US($STR_BUSCA)."' || PTA.D_FIM = '".Funcoes\DataBR2US($STR_BUSCA)."' )";
            }	
            
            $R = $this->util->query($sql);

            return $R;
        }

    }

?>