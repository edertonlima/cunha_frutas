<?php get_header(); ?>

	<div class="main-title" style="">
		<div class="container">
			<h3 class="titulo"><?php the_title(); ?></h3>
			<p class="subtitulo"><?php the_field('subtitulo'); ?></p>
		</div>
	</div>

	<section class="box-content">
		<div class="container">

			<div class="row">
				<div class="col-12">
					<?php
						while ( have_posts() ) : the_post(); ?>
							
							<?php $imagem = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' ); ?>

							<?php if($imagem[0]){ ?>
								<div class="col-6">						
									<img src="<?php echo $imagem[0]; ?>" class="img-page">
								</div>
							<?php } ?>	

							<div class="col-<?php if($imagem[0]){ echo '6'; }else{ echo '12'; } ?>">
								<div class="content-txt">
									<?php the_content(); ?>
								</div>
							</div>					

						<?php endwhile;
						wp_reset_query();
					?>

					<?php if(have_rows('colunas')):
						$count_colunas = 12/(count(get_field('colunas'))); ?>
						<div class="content-txt <?php if(get_the_content()){ echo 'margin-60'; } ?>">
							<?php while ( have_rows('colunas') ) : the_row(); ?>

								<div class="col-<?php echo $count_colunas; ?>">
									<p class="justify"><?php the_sub_field('texto'); ?></p>
								</div>

							<?php endwhile; ?>
						</div>
					<?php endif; ?>	
				</div>
			</div>

			<div class="row">
				<div class="col-12">

					<div class="col-7">
						<form action="javascript:" class="form-padrao">
							<fieldset class="col-12">
								<h4>Envie sua mensagem para nós:</h4>
								<p class="msg-form"></p>
							</fieldset>
							<fieldset class="col-12">
								<input type="text" name="nome" id="nome" placeholder="Nome: *">
							</fieldset>
							<fieldset class="col-12">
								<input type="text" name="email" id="email" placeholder="E-mail: *">
							</fieldset>
							<fieldset class="col-12">
								<textarea name="mensagem" id="mensagem" cols="30" rows="10" placeholder="Mensagem: *"></textarea>
							</fieldset>
							<fieldset class="col-12">
								<button class="btn btn-saiba-mais enviar" type="submit">Enviar</button>
							</fieldset>
						</form>
					</div>
					<div class="col-5">
						<div class="info-header info-contato form-contato">
							<div class="item-info-header escreva">
								<i class="fa fa-headphones"></i>
								<span class="title">Fale Conosco</span>
								<span class="subtitle">+55 47 3344-1697</span>
							</div>

							<div class="item-info-header escreva">
								<i class="fa  fa-clock-o"></i>
								<span class="title">Atendimento</span>
								<span class="subtitle">08:00 - 18:00</span>
							</div>

							<div class="item-info-header escreva">
								<i class="fa  fa-envelope-o"></i>
								<span class="title">Escreva-nos</span>
								<span class="subtitle">valdeir.repres@hotmail.com</span>
							</div>

							<div class="item-info-header escreva">
								<i class="fa fa-map-marker"></i>
								<span class="title">Endereço</span>
								<span class="subtitle">Rua Vereador Nestor dos Santos, 1155<br>Cordeiros, Itajaí, SC</span>
							</div>
						</div>
					</div>
					
				</div>
			</div>

		</div>
	</section>

<?php get_footer(); ?>

<script type="text/javascript">
	jQuery(".enviar").click(function(){
		jQuery('.enviar').html('ENVIANDO').prop( "disabled", true );
		jQuery('.msg-form').removeClass('erro ok').html('');
		var nome = jQuery('#nome').val();
		var email = jQuery('#email').val();
		var mensagem = jQuery('#mensagem').val();
		var para = '<?php the_field('email', 'option'); ?>';
		var nome_site = '<?php bloginfo('name'); ?>';

		if(nome == ''){
			jQuery('#nome').parent().addClass('erro');
		}

		if(email == ''){
			jQuery('#email').parent().addClass('erro');
		}

		if(mensagem == ''){
			jQuery('#mensagem').parent().addClass('erro');
		}

		if((nome == '') || (email == '') || (mensagem == '')){
			jQuery('.msg-form').html('Campos obrigatórios não podem estar vazios.');
			jQuery('.enviar').html('ENVIAR').prop( "disabled", false );
		}else{
			jQuery.getJSON("<?php echo get_template_directory_uri(); ?>/mail.php", { nome:nome, email:email, mensagem:mensagem, para:para, nome_site:nome_site }, function(result){		
				if(result=='ok'){
					resultado = 'Enviado com sucesso! Obrigado.';
					classe = 'ok';
				}else{
					resultado = result;
					classe = 'erro';
				}
				jQuery('.msg-form').addClass(classe).html(resultado);
				jQuery('.form-padrao').trigger("reset");
				jQuery('.enviar').html('ENVIAR').prop( "disabled", false );
			});
		}
	});

	jQuery(document).ready(function(){
		jQuery('input').change(function(){
			if(jQuery(this).parent().hasClass('erro')){
				jQuery(this).parent().removeClass('erro');
			}
		});

		jQuery('textarea').change(function(){
			if(jQuery(this).parent().hasClass('erro')){
				jQuery(this).parent().removeClass('erro');
			}
		});
	})
</script>