<?php

namespace App\Action;

use App\Interfaces;
use Funcoes;

class ProjetosViewAction extends Action implements Interfaces\ActionView{

  
    function novo($request,$response){
            
        //$vars['INT_PROJ'] = $request->getAttribute('id');
        
        $vars['page'] = 'principal';
        $vars['include'] = 'projetos/formulario.php';
        $response = $this->view->render($response,'index.php',$vars);

        return $response;
        
    }

    function renderizar($projetos){

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
}
?>