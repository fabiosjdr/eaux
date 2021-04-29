<?php
    namespace App\Action;

    use App\Interfaces;
    use Funcoes;

    class AtividadesViewAction implements Interfaces\ActionView{
    

        function renderizar($atividades){

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

    }

?>