<?php

namespace Util;

use PDOException;

//class Util extends UtilModel{   
class Util {   

    function __construct( $container) {                   
        $this->container = $container;         
    }

    public $campos;
    public $valores;
   
    public function getPosts($request){

        $data = $request->getParsedBody();
        
        if($data){
            
            $data = filter_var_array($data,FILTER_SANITIZE_STRING);
            foreach ($data as $key => $value) {           
               $dados[$key] = $value;
            }

            return $dados;

        }else{

            return '';
        }
       
    }

    public function getTable($tabela,$id = null ,$campos = null,$innerjoin = null){
       
        $primarykey = $this->getPrimaryKey($tabela);
        
        $sql = 'SELECT ';

        $sql .= ($campos)? join(',',$campos): '*';

        $sql .= ' FROM '.$tabela;

        $sql .= ($innerjoin)? ' '.$innerjoin: '';

        $sql .= ($id)? ' where '.$primarykey.' = '.$id : '';
        //echo $sql;exit;
        $result = $this->container->utilModel->query($sql);

        return $result->fetch(\PDO::FETCH_OBJ);
    }

    public function getPrimaryKey($tabela){

        $sql = "SHOW KEYS FROM $tabela WHERE Key_name = 'PRIMARY'"; 
        $query = $this->container->db->prepare($sql);
        $query->execute(); 
 
        $result = $query->fetchObject();
      
        return $result->Column_name;
 
    }    


}

?>