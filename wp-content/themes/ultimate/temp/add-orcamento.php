<?php 
	session_start();

	session_cache_limiter('private');
	$cache_limiter = session_cache_limiter();
	session_cache_expire(10);
	$cache_expire = session_cache_expire();

	if((isset($_SESSION['orcamento'])) and (count($_SESSION['orcamento']) > 0)){

		$adiciona = true;
		foreach ($_SESSION['orcamento'] as $key => $value) {
			if($value['id'] == $_GET['id']){
				$adiciona = false;
			}
		}

		if($adiciona){
			$_SESSION['orcamento'][] = array(
				'id'		=> $_GET['id'],
				'nome'		=> $_GET['nome'],
				'quantidade'	=> '1',
				'codigo'	=> $_GET['codigo']
			);
			if(end($_SESSION['orcamento'])['id'] == $_GET['id']){
				echo(json_encode('ok'));
			}else{
				echo(json_encode('erro'));
			}
		}else{
			echo(json_encode('ja-existe'));
		}

	}else{
		$_SESSION['orcamento'][] = array(
			'id'		=> $_GET['id'],
			'nome'		=> $_GET['nome'],
			'quantidade'	=> '1',
			'codigo'	=> $_GET['codigo']
		);
		if(end($_SESSION['orcamento'])['id'] == $_GET['id']){
			echo(json_encode('ok'));
		}else{
			echo(json_encode('erro'));
		}
	}
?>