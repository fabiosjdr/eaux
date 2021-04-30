<?php

    namespace Util\Classes;

    class GetTabela{
        
        private $tabela;

        function __construct($NM_TABELA){
            $this->tabela = $NM_TABELA;
        }

        public function getNomeTabela(){
            return $this->tabela;
        }
    }
    

?>