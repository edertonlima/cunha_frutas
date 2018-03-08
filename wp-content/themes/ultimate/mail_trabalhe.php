<?php
$url = $_POST['url'];
$url_curriculo = $_POST['url_curriculo'];

// Pasta onde o arquivo vai ser salvo
$_UP['pasta'] = 'curriculos/';
// Tamanho máximo do arquivo (em Bytes)
$_UP['tamanho'] = 1024 * 1024 * 2; // 2Mb
// Array com as extensões permitidas
$_UP['extensoes'] = array('pdf');
// Renomeia o arquivo? (Se true, o arquivo será salvo como .jpg e um nome único)
$_UP['renomeia'] = true;
// Array com os tipos de erros de upload do PHP
$_UP['erros'][0] = 'Não houve erro';
$_UP['erros'][1] = 'O arquivo no upload é maior do que o limite do PHP';
$_UP['erros'][2] = 'O arquivo ultrapassa o limite de tamanho especifiado no HTML';
$_UP['erros'][3] = 'O upload do arquivo foi feito parcialmente';
$_UP['erros'][4] = 'Não foi feito o upload do arquivo';
// Verifica se houve algum erro com o upload. Se sim, exibe a mensagem do erro
if ($_FILES['arquivo']['error'] != 0) {
  //die("Não foi possível fazer o upload, erro:" . $_UP['erros'][$_FILES['arquivo']['error']]);
  header("Location: ".$url."/?form=error");
  exit; // Para a execução do script
}
// Caso script chegue a esse ponto, não houve erro com o upload e o PHP pode continuar
// Faz a verificação da extensão do arquivo
$extensao = strtolower(end(explode('.', $_FILES['arquivo']['name'])));
if (array_search($extensao, $_UP['extensoes']) === false) {
  //echo "Por favor, envie apenas arquivo em PDF";
  header("Location: ".$url."/?form=error-extensao");
  exit;
}
// Faz a verificação do tamanho do arquivo
if ($_UP['tamanho'] < $_FILES['arquivo']['size']) {
  //echo "O arquivo enviado é muito grande, envie arquivos de até 2Mb.";
  header("Location: ".$url."/?form=error-size");
  exit;
}
// O arquivo passou em todas as verificações, hora de tentar movê-lo para a pasta
// Primeiro verifica se deve trocar o nome do arquivo
if ($_UP['renomeia'] == true) {
  // Cria um nome baseado no UNIX TIMESTAMP atual e com extensão .jpg
  $nome = $_POST['nome'];
  $nome_arquivo = str_replace(" ", "_", strtolower($nome));
  $nome_final = $nome_arquivo.'-'.md5(time()).'.'.$extensao;
} else {
  // Mantém o nome original do arquivo
  $nome_final = $_FILES['arquivo']['name'];
}

  
// Depois verifica se é possível mover o arquivo para a pasta escolhida
if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $_UP['pasta'] . $nome_final)) {
  // Upload efetuado com sucesso, exibe uma mensagem e um link para o arquivo
  //echo "Upload efetuado com sucesso!";
  $url_curriculo = '<a href="'.$url_curriculo.'/' . $_UP['pasta'] . $nome_final . '" target="_blank">Clique aqui para acessar o currículo</a>';
} else {
  // Não foi possível fazer o upload, provavelmente a pasta está incorreta
  //echo "Não foi possível enviar o arquivo, tente novamente";
  header("Location: ".$url."/?form=error-upload");
}

	$email = $_POST['email'];
	$tel_princ = $_POST['tel_princ'];
	$tel_sec = $_POST['tel_sec'];
	$endereco = $_POST['endereco'];
	$estado = $_POST['estado'];
	$cidade = $_POST['cidade'];
	$mensagem = $_POST['mensagem'];

	$nome_site = $_POST['nome_site'];
	$para = $_POST['para'];

	$email_remetente = 'contato@ultimate.com.br';
	$para = 'edertton@gmail.com';

	$headers = "MIME-Version: 1.0" . "\r\n";
	$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
	$headers .= "From: $nome_site <$email_remetente>\n";
	$headers .= "Return-Path: $nome_site <$email_remetente>\n";
	$headers .= "Reply-To: $nome <$email>\n";

	$conteudo = '
	<h2>Você recebeu um novo currículo.</h2>
	<p>Confira logo abaixo, todos os dados preenchidos no formulário da área "Trabalhe Conosco":</p>';

	$conteudo .= '<p>';
	$conteudo .= '<strong>Nome:</strong> '.$nome;
	$conteudo .= '<br><strong>E-mail:</strong> '.$email;
	$conteudo .= '<br><strong>Telefone Principal:</strong> '.$tel_princ;
	$conteudo .= '<br><strong>Telefone Secundário:</strong> '.$tel_sec;
	$conteudo .= '<br><strong>Endereco:</strong> '.$endereco;
	$conteudo .= '<br><strong>Estado:</strong> '.$estado;
	$conteudo .= '<br><strong>Cidade:</strong> '.$cidade;
	$conteudo .= '<br><strong>Mensagem:</strong> '.$mensagem;
	$conteudo .= '</p>';
	$conteudo .= '<p><strong>Currículo enviado:</strong><br>'.$url_curriculo.'</p>';
	if(mail($para, "Contato, Trabalhe Conosco", $conteudo, $headers, "-f$email_remetente")){
		mail('edertton@gmail.com', "Contato, Trabalhe Conosco", $conteudo, $headers, "-f$email_remetente");
		//echo $conteudo;
		//echo(json_encode('ok'));
		header("Location: ".$url."/?form=success");
	}else{
		header("Location: ".$url."/?form=error");
		//echo(json_encode("Desculpe, não foi possível enviar seu formulário. <br>Por favor, tente novamente mais tarde."));
	}
	
?>