<?php
    
    namespace App\Action;
    use App\Interfaces;

    Class ModelAction extends Action implements Interfaces\ActionModel{

        function __construct($container){

            parent::__construct($container);
            $this->setTabela('PROJETOS');
        }

        function editar($request,$response){
        
            $id = $request->getAttribute('id');
            
            if(!is_numeric($id)){    
                $vars['page'] = '404/404';               
            }else{

                $dados = $this->util->getTable($this->getTabela(),$id);           
                $vars['dados'] = $dados;
                $vars['page'] = 'principal';			            
                $vars['include'] = 'projetos/formulario.php';
            }
            
            return $vars;
    
        }

        function salvar($request,$response){
            return '';
        }


        function delete($request,$response){
            return '';
        }
    }

?>