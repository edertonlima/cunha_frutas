<?php get_header(); ?>

	<section class="box-content fale-conosco">
		<div class="container">

			<div class="row">
				<div class="col-12">
					<h2>
						FALE CONOSCO
					</h2>
				</div>

				<div class="col-8">

					<?php
						while ( have_posts() ) : the_post(); 
							
							get_template_part( 'content', 'post' );

						endwhile;
						wp_reset_query();
					?>

					<div class="contato-footer page">

						<div class="col-6">
							<?php if(get_field('telefone','option')){ ?>
								<span class="tel">
									<?php the_field('telefone','option');
									/*if(get_field('info_telefone','option')){ ?>
										<span><?php the_field('info_telefone','option'); ?></span>
									<?php } */?>
								</span>
							<?php } ?>

							<?php if(get_field('celular','option')){ ?>
								<span class="tel">
									<?php the_field('celular','option');
									/*if(get_field('info_celular','option')){ ?>
										<span><?php the_field('info_celular','option'); ?></span>
									<?php }*/ ?>
								</span>
							<?php } ?>

							<?php if(get_field('email','option')){ ?>
								<span class="email"><?php the_field('email','option'); ?></span>
							<?php } ?>
						</div>

						<div class="col-6">
							<?php if(get_field('horario_atendimento','option')){ ?>
								<h4>Horário de Atendimento</h4>
								<p><?php the_field('horario_atendimento','option'); ?></p>
							<?php } ?>
						</div>		
					</div>

					<?php if( have_rows('filiais','option') ): ?>
						<?php while ( have_rows('filiais','option') ) : the_row(); ?>
							<div class="maps-filiais row">
								<h2><?php the_sub_field('nome','option'); ?></h2>
								<div class="col-8">
									<?php the_sub_field('mapa','option'); ?>
								</div>
								<div class="col-4">
									<p><?php the_sub_field('endereco'); ?></p>
								</div>
							</div>
						<?php endwhile; ?>
					<?php endif;  ?>

					<?php if( have_rows('nossa_equipe') ): ?>
							<div class="content-txt nossa-equipe">
							<?php while ( have_rows('nossa_equipe') ) : the_row(); ?>
								<li class="col-4">
									<?php if(get_sub_field('imagem')){ ?>
										<img src="<?php the_sub_field('imagem'); ?>" alt="<?php the_sub_field('nome'); ?>">
									<?php } ?>
									<h4><?php the_sub_field('nome'); ?></h4>
								</li>
							<?php endwhile; ?>
							</div>
					<?php endif;  ?>

					<?php //the_excerpt(); ?>

					<div class="row">
						<form action="javascript:" class="form-padrao">
							<fieldset class="col-12">
								<h4 style="margin-top: 50px;">Envie sua mensagem para nós:</h4>
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
								<button class="enviar" type="submit">Enviar</button>
							</fieldset>
						</form>
					</div>
					
				</div>

				<div class="col-4 sidebar">

					<?php include 'sidebar-empresa.php'; ?>
					<?php include 'sidebar-noticias.php'; ?>

				</div>
			</div>

		</div>
	</section>

<?php get_footer(); ?>

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.nav ul li.menu-fale-conosco').addClass('active');
	});
</script>

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