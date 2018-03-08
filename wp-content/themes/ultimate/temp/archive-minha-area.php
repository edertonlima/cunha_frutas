<?php 
	session_start();

	if(isset($_SESSION['id'])){ //echo '<br>tem session';
		
		$url = get_post_permalink($_SESSION['id']).'#novo-pedido';
		header('Location: '.$url);

	}else{ //echo '<br>não tem session';


		if((isset($_POST['usuario'])) and ($_POST['usuario'] != '')){ //echo '<br>tem POST';

			$usuario = get_posts(array(
				'numberposts'	=> 1,
				'post_type'		=> 'minha-area',
				'meta_query' => array(
					array(
						'key'     => 'usuario',
						'value'   => $_POST['usuario'],
					),
					array(
						'key'     => 'senha',
						'value'   => $_POST['senha'],
					),
					array(
						'key'     => 'status',
						'value'   => true,
					),
				),
			));

			if(count($usuario)){ //echo '<br>tem usuario';

				session_cache_limiter('private');
				$cache_limiter = session_cache_limiter();
				session_cache_expire(10);
				$cache_expire = session_cache_expire();

				$_SESSION['usuario'] = $_POST['usuario'];
				$_SESSION['senha'] = $_POST['senha'];
				$_SESSION['id'] = $usuario[0]->ID;
				$url = get_post_permalink($_SESSION['id']).'#novo-pedido';
				header('Location: '.$url);

				 //echo '<br>logado';

			}else{ //echo '<br> não tem usuario';
				$msg = '<p><strong>Não foi possivel entrar em sua área.</strong><br>Por favor, verifique seu nome de usuário e sua senha ou se o seu cadastro ainda não foi verificado, você não conseguirá acessar a sua área.</p>';
			}
		}else{ //echo '<br>não tem POST';
			
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
						Login
					</span>

					<?php 
						if((isset($_SESSION['id'])) and ($_SESSION['id'] != '')){ ?>
							<a href="javascript: logOff();" class="logOff" title="Sair">
								Sair <i class="fa fa-sign-out" aria-hidden="true"></i>
							</a>
						<?php }
					?>
				</h2>

				<div class="row">
					<div class="col-12">

						<form action="<?php echo get_home_url(); ?>/minha-area" class="login" method="post">

							<?php if((isset($_POST['usuario'])) and (isset($_POST['senha']))){ ?>
								<fieldset class="col-12">
									<?php echo $msg; ?>
								</fieldset>
							<?php } ?>

							<fieldset class="col-12">
								<input type="text" name="usuario" id="usuario" placeholder="Usuário">
							</fieldset>

							<fieldset class="col-12">
								<input type="password" name="senha" id="senha" placeholder="Senha">
							</fieldset>

							<fieldset class="col-12">
								<button type="submit" class="btn enviar">Entrar</button>
								<!--<a href="javascript:" class="btn enviar">Entrar</a>-->
							</fieldset>

							<fieldset class="col-12">
								<p class="msg-form"></p>
								<p>Primeiro acesso? <a href="<?php echo get_home_url(); ?>/cadastro" title="Cadastre-se aqui">Cadastre-se aqui.</a></p>
							</fieldset>
						</form>
					</div>
				</div>

			</div>
		</div>

	</div>
</section>

<?php get_footer(); ?>

<script type="text/javascript">
	jQuery('form.login').submit(function(event){

		jQuery('.enviar').html('Enviando').prop( "disabled", true );
		jQuery('.msg-form').removeClass('erro ok').html('');

		var usuario = jQuery('#usuario').val();
		var senha = jQuery('#senha').val();		

		var enviar = true;

		if(usuario == ''){
			jQuery('#usuario').parent().addClass('erro');
			enviar = false;
		}

		if(senha == ''){
			jQuery('#senha').parent().addClass('erro');
			enviar = false;
		}

		if(!enviar){
			jQuery('.msg-form').html('Todos os campos são obrigatórios.');
			jQuery('.enviar').html('Entrar').prop( "disabled", false );
			return false;
		}else{
			jQuery('.enviar').html('Enviar').prop( "disabled", false );
			//event.preventDefault();
		}		
		
	});

	/*jQuery(".enviar").click(function(){

	});*/

	jQuery(document).ready(function(){
		jQuery('input').change(function(){
			if(jQuery(this).parent().hasClass('erro')){
				jQuery(this).parent().removeClass('erro');
			}
		});
	})
</script>