<?php

namespace Util;

use PDOException;

class Util{   

    protected $container;
    public $campos;
    public $valores;
   
    private $TABELA;    
    
    function __construct( $container) {        
        
        $this->container = $container;              

    }
   
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

    public function sqlPrimarykey($tabela){

        $primary = $this->getPrimaryKey($tabela);
        return  " , '$primary' AS primarykey ";
    }

    public function getPrimaryKey($tabela){

        $sql = "SHOW KEYS FROM $tabela WHERE Key_name = 'PRIMARY'"; 
        $query = $this->container->db->prepare($sql);
        $query->execute(); 
 
        $result = $query->fetchObject();
      
        return $result->Column_name;
 
    }
    
    
    public function testConnection(){

        if($this->container->db);
    }


}

?>