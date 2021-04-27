<?php

    namespace App\Action;
	use Util;
    use PDOException;

final class IniciarAction extends Action{
        
		function __construct($container){
			//aqui nao posso usar o contruct parent senao fica em loop com a tela de primeiro acesso
			$this->container = $container;
			$this->util =  new util\Util($container);			
		}

		function processar($request,$response){			
			
			$dbconf =  $this->util->getPosts($request);
			$configfile = BASEPATH.'/App/inc/config.json';
			
			if(file_exists($configfile)){
				unlink($configfile);
			}

			file_put_contents($configfile,json_encode($dbconf) );

			try{

				$pdo = new \PDO('mysql:host=' . $dbconf['host'] . ';charset=utf8', $dbconf['user'], $dbconf['pass']);
				$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);

				$script = file_get_contents(BASEPATH.'/Base/base.sql');

				$script = preg_replace('/DB_DESAFIO/',$dbconf['dbname'],$script);

				$query = $pdo->prepare($script);
				$query->execute();

			}catch(PDOException $e){
				
				$saida['sucesso'] = false;
				$saida['mensagem'] = $e;

			}finally{
				
				$saida['sucesso'] = true;
				$saida['mensagem'] ='agora e so importar';
				
			}
            
			
			echo json_encode($saida);exit;
			
		}

	

	}
	
?>