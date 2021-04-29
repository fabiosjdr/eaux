<?php
    namespace App\Interfaces;

    interface ActionControler{
        public function index();
    }

    interface ActionModel{
        public function novo($request,$response);
        public function salvar($request,$response);
        public function delete($request,$response);
        public function editar($request,$response);
    }

    interface ActionView{
        public function renderizar($resultado);
    }
?>