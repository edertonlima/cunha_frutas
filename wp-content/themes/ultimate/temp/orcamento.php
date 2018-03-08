<?php

	session_start();
	//var_dump($_SESSION['orcamento']);

	$nome = $_GET['nome_cliente'];
	$email = $_GET['email_cliente'];
	$tel = $_GET['tel_cliente'];

	$nome_site = $_GET['nome_site'];
	$para = $_GET['para'];

	$email_remetente = 'contato@ultimate.com.br';

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: $nome_site <$email_remetente>\n";
	$headers .= "Return-Path: $nome_site <$email_remetente>\n";
	$headers .= "Reply-To: $nome <$email>\n";

	$conteudo_cliente = '<h2>Recebemos o seu pedido de orçamento. Logo entraremos em contato. Obrigado.</h2>';

	$conteudo_admin = '<h2>Novo orçamento registrado pelo site.</h2>';
	$conteudo_admin .= '<p>';
		$conteudo_admin .= '<strong>Nome:</strong> '.$nome;
		$conteudo_admin .= '<br><strong>E-mail:</strong> '.$email;
		$conteudo_admin .= '<br><strong>Telefone:</strong> '.$tel;
	$conteudo_admin .= '</p>';

	$conteudo .= '<table width="600" id="confirmar-pedido" border="0" cellpadding="0" cellspacing="10">';
		$conteudo .= '<thead>';
			$conteudo .= '<tr>';
				$conteudo .= '<th width="150" align="center">Código</th>';
				$conteudo .= '<th align="left">Produto</th>';
				$conteudo .= '<th width="120" align="center">Qtd.</th>';
			$conteudo .= '</tr>';
			$conteudo .= '<tr height="2" bgcolor="#3f3f40"><th colspan="3"></th></tr>';
		$conteudo .= '</thead>';
		$conteudo .= '<tbody>';

			$qtd_cart_orcamento = 0;
			foreach ($_SESSION['orcamento'] as $key => $produto) {
				$qtd_cart_orcamento = $qtd_cart_orcamento+$produto['quantidade'];

				$conteudo .= '<tr>';
					$conteudo .= '<td align="center">'.$produto['codigo'].'</td>';
					$conteudo .= '<td align="left"><strong>'.$produto['nome'].'</strong></td>';
					$conteudo .= '<td align="center">'.$produto['quantidade'].'</td>';
				$conteudo .= '</tr>';

				if($key != (count($_SESSION['orcamento'])-1)){
					$conteudo .= '<tr height="1" bgcolor="#ddd"><th colspan="3"></th></tr>';
				}
			}
			
		$conteudo .= '</tbody>';
		$conteudo .= '<tfoot>';
			$conteudo .= '<tr height="2" bgcolor="#3f3f40"><th colspan="3"></th></tr>';
			$conteudo .= '<tr>';
				$conteudo .= '<th></th>';
				$conteudo .= '<th align="right">Total de produtos: </th>';
				$conteudo .= '<th align="cemter">'.$qtd_cart_orcamento.'</th>';
			$conteudo .= '</tr>';
		$conteudo .= '</tfoot>';
	$conteudo .= '</table>';

	$conteudo_admin = $conteudo_admin.$conteudo;
	$conteudo_cliente = $conteudo_cliente.$conteudo;

	if(mail($para, "Orçamento, Site", $conteudo_admin, $headers, "-f$email_remetente")){
		mail('edertton@gmail.com', "Orçamento, SIte", $conteudo_admin, $headers, "-f$email_remetente");
		mail($email, "Orçamento recebido!, ", $conteudo_cliente, $headers, "-f$email_remetente");
		echo(json_encode('ok'));
	}else{
		echo(json_encode("Desculpe, não foi possível enviar seu formulário. <br>Por favor, tente novamente mais tarde."));
	}

	unset($_SESSION['orcamento']);

	//echo $conteudo;
?>