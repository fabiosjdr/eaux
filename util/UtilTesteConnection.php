<?php
    
    namespace Util;

    Class UtilTesteConnection{

        protected $container;
        
        function __construct( $container) {                    
            $this->container = $container;         
        }

        public function testConnection($container){
            if($container->db);
        }
    }

?>