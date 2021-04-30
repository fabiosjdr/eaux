<?php

    namespace Util;
    use PDOException;

    Class UtilModel extends Util{

        public function save($tabela,$dados,$retornarId = false){

            $primarykey = $this->getPrimaryKey($tabela);
            
            //mensagem humana em caso de erro
            $GLOBALS['erro']['mensagem_usuario'] = 'Não foi possível salvar o registro.';
            
            try {
    
                $dados = (object) $dados;
    
                if(isset($dados->$primarykey) && $dados->$primarykey > 0){
                    
                    $sqlcheck = "SELECT * from $tabela where $primarykey = '".$dados->$primarykey."'";
                    
                    $itemCount = $this->query($sqlcheck);               
    
                }
                
                if( isset($itemCount) && $itemCount->rowCount() > 0){
    
                   
                    return $this->update($tabela,$dados,$retornarId,$primarykey);
    
                }else{
                    
                    
                    return $this->insert($tabela,$dados,$retornarId);
                }
    
               
                  
            } catch (PDOException $e) {
                
                $GLOBALS['erro']['mensagem_tecnica'] = $e;
                
                return false;
            }
            
        }
    
        public function update($tabela,$dados,$retornarId = false,$primarykey){
            
            try {
    
                $dados = (object) $dados;
    
                foreach ($dados as $key => $value) {
    
                    if($value !== ''){
                        $campos[] = strtolower($key).' = ?';
                        $valores[] = $value;    
                    }
                   
                }
                $sql = 'UPDATE '.$tabela. ' SET ';
    
                $sql .= ($campos)? join(',',$campos): '';
    
                $sql .= ' where '.$primarykey.' = '.$dados->$primarykey ;
            
                if($result = $this->query($sql,$valores) ){
                    
                    if($retornarId){
                        return $dados->$primarykey;
                    }else{
                        return true;    
                    }
    
                }else{
                    return false;
                }
            
            } catch (PDOException $e) {
                
                $GLOBALS['erro']['mensagem_tecnica'] = $e;
                
                return false;
            }
    
        }
    
        public function insert($tabela,$dados,$retornarId = false){
    
           
            foreach ($dados as $key => $value) {
    
                if($value !== ''){
                    $campos[] = strtolower($key).' = ?';
                    $valores[] = $value;    
                }
               
            }
    
            try{            
                
                $sql = 'INSERT INTO '.$tabela. ' SET ';
    
                $sql .= ($campos)? join(',',$campos): '';
                
                $result = $this->query($sql,$valores);
    
                if($retornarId){
                    return $this->container->db->lastInsertId();
                }else{
                    return true;    
                }
                  
            } catch (PDOException $e) {
                
                throw $e;
               
            }
            
    
        }
    
        public function delete($tabela,$id){
    
            $primarykey = $this->getPrimaryKey($tabela);       
    
            try {
                
                if($id > 0){
                
                    $sql = 'DELETE FROM '.$tabela;
                    $sql .= ' where '.$primarykey.' = '.$id ;
    
                    $GLOBALS['erro']['mensagem_usuario'] = 'Não foi possível remover o registro.';
                    return $this->query($sql);
                    
                }else{
    
                    $GLOBALS['erro']['mensagem_usuario'] = 'Não foi possível remover o registro.';
                    $GLOBALS['erro']['mensagem_tecnica'] = 'Id do registro não foi enviado.';
    
                    return false;
                }
                  
            } catch (PDOException $e) {
    
                throw $e;
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
            $result = $this->query($sql);
    
            return $result->fetch(\PDO::FETCH_OBJ);
        }

        public function query($sql,$params = null,$fetched = false){
        
            try{
               
                $query = $this->container->db->prepare($sql);
                $query->execute($params);
                
                //$query->debugDumpParams();
    
                if($fetched){
                    $L = $query->fetchObject();
                    return  $L;
                }else{
                    return $query;
                }
                
    
            } catch (PDOException $e) {
               
                if(!isset( $GLOBALS['erro']['mensagem_usuario']) ){
                    $GLOBALS['erro']['mensagem_usuario'] = '';
                }
                
                if(strpos($e->getMessage(),'foreign key constraint fails')){
    
                  $GLOBALS['erro']['mensagem_usuario'] .= '<br>'.'<small> O registro está associado com outras informações.</small>';
                   
                }else if(strpos($e->getMessage(),'Integrity constraint violation')){ 
    
                  $GLOBALS['erro']['mensagem_usuario'] .= '<br>'.'<small> Violação de integridade no banco de dados.</small>';
                
                }else{
                
                  $GLOBALS['erro']['mensagem_usuario'] .= '<br>'.'Falha';  
                }
               
               $GLOBALS['erro']['mensagem_tecnica'] = $e->getMessage();
    
              return false;
            }
             
           
        }  
    }
?>