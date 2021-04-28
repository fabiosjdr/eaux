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
			
			try{

				$pdo = new \PDO('mysql:host=' . $dbconf['host'] . ';charset=utf8', $dbconf['user'], $dbconf['pass']);
				$pdo->setAttribute(\PDO::ATTR_ERRMODE,\PDO::ERRMODE_EXCEPTION);

				$script = file_get_contents(BASEPATH.'/Base/base.sql');

				$script = preg_replace('/DB_DESAFIO/',$dbconf['dbname'],$script);

				$query = $pdo->prepare($script);
				
				
				if( $query->execute() ){

					$saida['sucesso'] = true;
					$saida['mensagem'] =  $this->gerarArquivoConf($configfile,$dbconf);
				}else{

					$saida['sucesso'] = false;
					$saida['mensagem'] = 'Falha ao conectar ao banco de dados com as informações fornecidas';
				}

				

			}catch(PDOException $e){
				
				$saida['sucesso'] = false;
				$saida['mensagem'] = $e->errorInfo[2];

			}
				
			
			echo json_encode($saida);exit;
			
		}

		function gerarArquivoConf($configfile,$dbconf){
			
			if(!is_writable($configfile)){

				return 'Sue banco de dados foi instalado com sucesso, porém o arquivo <b>'.$configfile.'</b> não tem permissão de escrita, 
						por favor conceda permissão ou caso prefira insira manualmente com os seguintes dados. 
						<pre>'.\json_encode($dbconf).'</pre>';


			}else{

				file_put_contents($configfile,json_encode($dbconf) );

				return 'Parabéns o sistema foi configurado corretamente. <input type="button" onclick="javascript:window.location.reload()" value="Continuar">';
			}
		}

	

	}
	
?>