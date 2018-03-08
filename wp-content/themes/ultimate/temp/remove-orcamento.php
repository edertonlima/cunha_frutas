<?php 
	session_start();

	if((isset($_SESSION['orcamento'])) and (count($_SESSION['orcamento']) > 0)){

		foreach ($_SESSION['orcamento'] as $key => $value) {
			if($value['id'] == $_GET['id']){
				echo(json_encode('ok'));
				unset($_SESSION['orcamento'][$key]);
				break;
			}else{
				echo(json_encode('erro'));
			}
		}

	}else{
		echo(json_encode('erro'));
	}
?>