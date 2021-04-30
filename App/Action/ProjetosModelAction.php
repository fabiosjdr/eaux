<?php
namespace App\Action;

use App\Interfaces;
use Funcoes;

class ProjetosModelAction extends Action implements Interfaces\ActionModel{
	
    function __construct($container){

        parent::__construct($container);
        $this->setTabela('PROJETOS');
    }
    
    function editar($request,$response){
        
        $id = $request->getAttribute('id');
        
        if(!is_numeric($id)){

            $vars['page'] = '404/404';
            $response = $this->view->render($response,'index.php',$vars);
            return $response;
            //return $response->withRedirect(BASEURL);
        }
        
        $dados = $this->util->getTable($this->getTabela(),$id);
       
        $vars['dados'] = $dados;
        $vars['page'] = 'principal';			
        
        $vars['include'] = 'projetos/formulario.php';
        $response = $this->view->render($response,'index.php',$vars);

        return $response;

    }

    function delete($request,$response){
    
        $id = $request->getAttribute('id');

        if(!is_numeric($id)){
            $vars['page'] = '404';
            $response = $this->view->render($response,'index.php',$vars);
            return $response;
            //return $response->withRedirect(BASEURL);
        }

        if($this->util->delete($this->getTabela(),$id) ){

            return $response->withRedirect(BASEURL.'projetos');

        }else{

            $vars['page'] = 'painel';
            $vars['erro'] = $GLOBALS['erro'];
            $vars['include'] = 'erro/erro.php';
            $response = $this->view->render($response,'index.php',$vars);
            return $response;
        }

        
        
    }

    function salvar($request,$response){
        
        $dados =  $this->util->getPosts($request);
        
              
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

    function obter($STR_BUSCA =  ''){

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