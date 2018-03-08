<?php
	if(isset($_POST['nome'])){

		if($_POST['pessoa'] == '.pf'){
			$nome = $_POST['nome'];
			$doc = $_POST['cpf'];
			$tipo = false;
		}else{
			$nome = $_POST['razao_social'];
			$doc = $_POST['cnpj'];
			$tipo = true;
		}

		$new_post = array(
			'post_type' => 'minha-area',
			'post_title' => $nome,
			'post_status' => 'publish'
		);

		if($post_id = wp_insert_post($new_post)){

			$usuario = explode(' ', $nome); 
			$usuario = strtolower($usuario[0]).$post_id;

			update_field( 'cpf__cnpj', $doc, $post_id );
			update_field( 'email', $_POST['email'], $post_id );

			update_field( 'telefone', $_POST['telefone'], $post_id );
			update_field( 'celular', $_POST['celular'], $post_id );

			update_field( 'endereco', $_POST['endereco'], $post_id );
			update_field( 'numero', $_POST['numero'], $post_id );
			update_field( 'bairro', $_POST['bairro'], $post_id );
			update_field( 'cidade', $_POST['cidade'], $post_id );
			update_field( 'uf', $_POST['uf'], $post_id );
			update_field( 'cep', $_POST['cep'], $post_id );

			update_field( 'nome_fantasia', $_POST['nome_fantasia'], $post_id );
			update_field( 'inscricao_estadual', $_POST['inscricao_estadual'], $post_id );
			update_field( 'email_xml', $_POST['email_xml'], $post_id );
			update_field( 'email_financeiro', $_POST['email_financeiro'], $post_id );
			
			update_field( 'usuario', $usuario, $post_id );
			update_field( 'senha', $_POST['senha'], $post_id );

			update_field( 'tipo',$tipo, $post_id );

			$novo_cliente = true;
		}else{
			$novo_cliente = false;
		}

	}
?>

<?php get_header(); ?>

<section class="box-content clientes">
	<div class="container">

		<div class="row">
			<div class="col-12">

				<h2>
					<a href="<?php echo get_home_url(); ?>/minha-area" title="ÁREA RESTRITA">
						ÁREA RESTRITA
					</a>
					<span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
						Novo Cadastro
					</span>

					<?php 
						if((isset($_SESSION['id'])) and ($_SESSION['id'] != '')){ ?>
							<a href="javascript: logOff();" class="logOff" title="Sair">
								Sair <i class="fa fa-sign-out" aria-hidden="true"></i>
							</a>
						<?php }
					?>
				</h2>

				<form action="<?php the_permalink(); ?>" class="cadastro" method="post">
					<div class="row">

						<fieldset class="col-12">

							<?php 
								if(isset($novo_cliente)){
									if($novo_cliente){
										echo '<p><strong>Cadastro recebido com sucesso!</strong><br>Você receberá um e-mail com a confirmação, assim que seu cadastro for aprovado.</p>';
									}else{
										echo '<p>Desculpe, não foi possivel enviar o seu cadastro.</p>';
									}
								}
							?>
							
							<div class="input-radio center">
								<label>
									<input type="radio" class="pessoa" name="pessoa" value=".pf" id="" checked="checked"> Pessoa Física
								</label>
								<label>
									<input type="radio" class="pessoa" name="pessoa" value=".pj" id=""> Pessoa Juridica
								</label>
							</div>
						</fieldset>

						<label class="col-12 titulo">Dados Principais:</label>
						<fieldset class="col-12">
							<input type="text" class="inputPessoa pf" name="nome" id="nome" placeholder="Nome*">
							<input type="text" class="inputPessoa pj" name="razao_social" id="razao_social" placeholder="Razão Social*">
						</fieldset>

						<fieldset class="col-12">
							<input type="text" class="inputPessoa pj" name="nome_fantasia" id="nome_fantasia" placeholder="Nome Fantasia">
						</fieldset>

						<fieldset class="col-6">
							<input type="text" class="inputPessoa mask-cpf pf" name="cpf" id="cpf" placeholder="CPF*">
							<input type="text" class="inputPessoa mask-cnpj pj" name="cnpj" id="cpnj" placeholder="CNPJ*">
						</fieldset>

						<fieldset class="col-6">
							<input type="text" class="inputPessoa pj" name="inscricao_estadual" id="inscricao_estadual" placeholder="Inscrição Estadual*">
						</fieldset>


						<label class="col-12 titulo">Informações de Contato:</label>
						<fieldset class="col-6">
							<input type="text" class="mask-telefone" name="telefone" id="telefone" placeholder="Telefone">
						</fieldset>

						<fieldset class="col-6">
							<input type="text" class="mask-telefone" name="celular" id="celular" placeholder="Celular">
						</fieldset>

						<fieldset class="col-12">
							<input type="text" name="email" id="email" placeholder="E-mail*">
						</fieldset>

						<fieldset class="col-6">
							<input type="text" class="inputPessoa pj" name="email_xml" id="email_xml" placeholder="E-mail XML">
						</fieldset>

						<fieldset class="col-6">
							<input type="text" class="inputPessoa pj" name="email_financeiro" id="email_financeiro" placeholder="E-mail Financeiro">
						</fieldset>


						<label class="col-12 titulo">Endereço:</label>
						<fieldset class="col-7">
							<input type="text" name="endereco" id="endereco" placeholder="Endereço*">
						</fieldset>

						<fieldset class="col-2">
							<input type="text" name="numero" id="numero" placeholder="N.º*">
						</fieldset>

						<fieldset class="col-3">
							<input type="text" name="cep" id="cep" class="mask-cep" placeholder="CEP*">
						</fieldset>

						<fieldset class="col-5">
							<input type="text" name="bairro" id="bairro" placeholder="Bairro*">
						</fieldset>

						<fieldset class="col-5">
							<input type="text" name="cidade" id="cidade" placeholder="Cidade*">
						</fieldset>

						<fieldset class="col-2">
							<input type="text" name="uf" id="uf" placeholder="UF*">
						</fieldset>
						

						<label class="col-12 titulo">Senha de acesso:</label>
						
						<fieldset class="col-12">
							<input type="password" name="senha" id="senha" placeholder="Senha*">
						</fieldset>

						<fieldset class="col-12">
							<button type="submit" class="btn enviar">Cadastrar</button>
							<!--<a href="javascript:" class="btn enviar">Cadastrar</a>-->
						</fieldset>

						<fieldset class="col-12">
							<p class="msg-form"></p>
							<?php if(!isset($_SESSION['id'])){ ?>
								<p>Já possui acesso? <a href="<?php echo get_home_url(); ?>/minha-area" title="Acessar minha área">Clique aqui.</a></p>
							<?php } ?>
						</fieldset>

					</div>
				</form>

			</div>
		</div>

	</div>
</section>

<?php get_footer(); ?>

<script type="text/javascript">
	jQuery("form.cadastro").submit(function(event){
		jQuery('.enviar').html('Enviando').prop( "disabled", true );
		jQuery('.msg-form').removeClass('erro ok').html('');

		var nome = jQuery('#nome').val();
		var razao_social = jQuery('#razao_social').val();		
		var nome_fantasia = jQuery('#nome_fantasia').val();		
		var email = jQuery('#email').val();
		var telefone = jQuery('#telefone').val();
		var celular = jQuery('#celular').val();
		var cpf = jQuery('#cpf').val();
		var cnpj = jQuery('#cnpj').val();
		var endereco = jQuery('#endereco').val();
		var numero = jQuery('#numero').val();
		var bairro = jQuery('#bairro').val();
		var cidade = jQuery('#cidade').val();
		var cep = jQuery('#cep').val();
		var uf = jQuery('#uf').val();
		var senha = jQuery('#senha').val();
		var inscricao_estadual = jQuery('#inscricao_estadual').val();
		var email_xml = jQuery('#email_xml').val();
		var email_financeiro = jQuery('#email_financeiro').val();

		var para = '<?php the_field('email', 'option'); ?>';
		var nome_site = '<?php bloginfo('name'); ?>';

		var enviar = true;

		if((jQuery('.pessoa').val()) == '.pf'){
			if(nome == ''){
				jQuery('#nome').parent().addClass('erro');
				enviar = false;
			}

			if(cpf == ''){
				jQuery('#cpf').parent().addClass('erro');
				enviar = false;
			}
		}else{
			if(razao_social == ''){
				jQuery('#razao_social').parent().addClass('erro');
				enviar = false;
			}

			/*if(nome_fantasia == ''){
				jQuery('#nome_fantasia').parent().addClass('erro');
				enviar = false;
			}*/

			if(cnpj == ''){
				jQuery('#cnpj').parent().addClass('erro');
				enviar = false;
			}
		}

		if(email == ''){
			jQuery('#email').parent().addClass('erro');
			enviar = false;
		}

		/*if(telefone == ''){
			jQuery('#telefone').parent().addClass('erro');
			enviar = false;
		}

		if(celular == ''){
			jQuery('#celular').parent().addClass('erro');
			enviar = false;
		}*/

		if(endereco == ''){
			jQuery('#endereco').parent().addClass('erro');
			enviar = false;
		}

		if(numero == ''){
			jQuery('#numero').parent().addClass('erro');
			enviar = false;
		}

		if(bairro == ''){
			jQuery('#bairro').parent().addClass('erro');
			enviar = false;
		}

		if(cidade == ''){
			jQuery('#cidade').parent().addClass('erro');
			enviar = false;
		}

		if(uf == ''){
			jQuery('#uf').parent().addClass('erro');
			enviar = false;
		}

		if(cep == ''){
			jQuery('#cep').parent().addClass('erro');
			enviar = false;
		}

		if(senha == ''){
			jQuery('#senha').parent().addClass('erro');
			enviar = false;
		}

		if(!enviar){
			jQuery('.msg-form').html('Todos os campos são obrigatórios.');
			jQuery('.enviar').html('Cadastrar').prop( "disabled", false );
			return false;
		}else{
			//jQuery('form').submit();
			//jQuery('form').trigger("reset");
			jQuery('.enviar').html('Enviar').prop( "disabled", false );
		}
	});

	jQuery(document).ready(function(){
		jQuery('input.pessoa').click(function(){
			jQuery('.inputPessoa').hide();
			jQuery(jQuery(this).attr('value')).show();
		});
	});

	jQuery(document).ready(function(){
		jQuery('input').change(function(){
			if(jQuery(this).parent().hasClass('erro')){
				jQuery(this).parent().removeClass('erro');
			}
		});
	})
</script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/maskedinput.js"></script>
<script type="text/javascript">
	jQuery(function(jQuery){
	   jQuery(".mask-telefone").mask("(99) 9999-9999?9");
	   jQuery(".mask-cpf").mask("999.999.999-99");
	   jQuery(".mask-cnpj").mask("99.999.999/9999-99");
	   jQuery(".mask-cep").mask("99999-999");
	});
</script>