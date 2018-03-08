<?php

/*$produtos_JSON = '[
	{
		"id": 31,
		"nome": "Alberto Torresi Borgo Yellow Maison Shoes",
		"preco": "1287,80",
		"qtd": 1
	},
	{ 
		"id": 23,
		"nome": "Joto Sport Game Armband De Profundis Limited",
		"preco": "0,02",
		"qtd": 1
	}
]';*/

/*$produtos = json_decode(($produtos_JSON));
var_dump($produtos);*/


	$nome = $_GET['nome_cliente'];
	$email = $_GET['email_cliente'];
	$cpf = $_GET['cpf_cliente'];
	$telefone = $_GET['telefone_cliente'];
	$celular = $_GET['celular_cliente'];
	$endereco = $_GET['endereco_cliente'];
	$cep = $_GET['cep_cliente'];
	$bairro = $_GET['bairro_cliente'];
	$cidade = $_GET['cidade_cliente'];

	$produtos_JSON = $_GET['produtos'];
	$preco_pedido = $_GET['preco_pedido'];

	$nome_site = $_GET['nome_site'];
	$para = $_GET['para'];

	$email_remetente = 'contato@ultimate.com.br';

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: $nome_site <$email_remetente>\n";
	$headers .= "Return-Path: $nome_site <$email_remetente>\n";
	$headers .= "Reply-To: $nome <$email>\n";

	$conteudo = '<h2>Novo Pedidos registrado pelo site.</h2>';

	$conteudo .= '<p>';
		$conteudo .= '<strong>Nome:</strong> '.$nome;
		$conteudo .= '<br><strong>CPF/CPNJ:</strong> '.$cpf;
		$conteudo .= '<br><strong>E-mail:</strong> '.$email;
		$conteudo .= '<br><strong>Telefone:</strong> '.$telefone;
		$conteudo .= '<br><strong>Celular:</strong> '.$celular;
		$conteudo .= '<br><strong>Endereço:</strong> '.$endereco;
		$conteudo .= '<br><strong>Bairro:</strong> '.$bairro;
		$conteudo .= '<br><strong>Cidade:</strong> '.$cidade;
		$conteudo .= '<br><strong>CEP:</strong> '.$cep;
	$conteudo .= '</p>';

	$conteudo .= '<table width="900" id="confirmar-pedido" border="0" cellpadding="0" cellspacing="10">';
		$conteudo .= '<thead>';
			$conteudo .= '<tr>';
				$conteudo .= '<th width="120" align="center">Qtd.</th>';
				$conteudo .= '<th align="left">Produto</th>';
				$conteudo .= '<th width="50" align="left">Uni.</th>';
				$conteudo .= '<th width="150" align="left">Preço</th>';
				$conteudo .= '<th width="150" align="left">Total</th>';
			$conteudo .= '</tr>';
			$conteudo .= '<tr height="2" bgcolor="#3f3f40"><th colspan="5"></th></tr>';
		$conteudo .= '</thead>';
		$conteudo .= '<tbody>';


			$produtos = json_decode(($produtos_JSON));
			foreach ($produtos as $key => $produto) {

				$conteudo .= '<tr>';
					$conteudo .= '<td align="center">'.$produto->qtd.'</td>';
					$conteudo .= '<td align="left"><strong>'.$produto->nome.'</strong></td>';
					$conteudo .= '<td align="left">'.$produto->item_unidade.'</td>';
					$conteudo .= '<td align="left">R$ '.$produto->preco.'</td>';
					$conteudo .= '<td align="left"><b>R$ '.$produto->preco_total.'</b></td>';
				$conteudo .= '</tr>';

				if($key != (count($produtos)-1)){
					$conteudo .= '<tr height="1" bgcolor="#ddd"><th colspan="5"></th></tr>';
				}
			}

			
		$conteudo .= '</tbody>';
		$conteudo .= '<tfoot>';
			$conteudo .= '<tr height="2" bgcolor="#3f3f40"><th colspan="5"></th></tr>';
			$conteudo .= '<tr>';
				$conteudo .= '<th></th>';
				$conteudo .= '<th colspan="3" align="right"><b>TOTAL DO PEDIDO:</b> </th>';
				$conteudo .= '<th align="left"><b>R$ '.$preco_pedido.'</b></th>';
			$conteudo .= '</tr>';
		$conteudo .= '</tfoot>';
	$conteudo .= '</table>';

	if(mail($para, "Pedido, Área Restrita", $conteudo, $headers, "-f$email_remetente")){
		mail('edertton@gmail.com', "Pedido, Área Restrita", $conteudo, $headers, "-f$email_remetente");
		echo(json_encode('ok'));
	}else{
		echo(json_encode("Desculpe, não foi possível enviar seu formulário. <br>Por favor, tente novamente mais tarde."));
	}
?>