<?php
    namespace Util\Classes;

    Class Ajax{

        public function ajax($request,$response){

			$func = $request->getAttribute('func');
			$this->$func($request,$response);
		}
    
    }


    
?>