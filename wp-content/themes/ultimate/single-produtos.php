<?php get_header(); ?>

	<?php 
		$terms = wp_get_post_terms( $post->ID, $post->post_type.'_taxonomy' );
		$categoria_id = $terms[0]->term_id;
	?>
	<?php $post_type = get_post_type_object( $post->post_type ); ?>

	<?php //$taxonomy = get_queried_object(); var_dump($taxonomy) ?>

	<div class="main-title" style="">
		<div class="container">
			<span class="categoria">
				<a href="<?php echo get_home_url(); ?>/produtos" title="PRODUTOS">
					PRODUTOS 
				</a>

				<i class="fa fa-angle-right" aria-hidden="true"></i>
				<a href="<?php echo get_category_link($terms[0]->term_id); ?>" title="<?php echo $terms[0]->name; ?>">
					<?php echo $terms[0]->name; ?>
				</a>
			</span>
			<h3 class="titulo"><?php the_title(); ?></h3>
		</div>
	</div>

	<section class="box-content produto det-produto">
		<div class="container">

			<div class="row">
				<div class="col-12">
					<div class="row">
						<?php
							while ( have_posts() ) : the_post(); ?>
								
								<?php $imagem = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>
								<?php $imagem2 = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' ); ?>

								<div class="col-6">
									<ul class="galeria-equipamento">
										<li class="img-principal">
											<a href="<?php echo $imagem2[0]; ?>" class="fancybox" data-fancybox="galeria"><img src="<?php echo $imagem[0]; ?>"><i class="fa fa-search" aria-hidden="true"></i></a>
										</li>
										<?php 
										$galeria = get_field('galeria');
										if( $galeria ):
											foreach( $galeria as $imagem ): ?>
											<li><a href="<?php echo $imagem['url']; ?>" class="fancybox" data-fancybox="galeria"><img src="<?php echo $imagem['sizes']['thumbnail']; ?>"/></a></li>
										<?php endforeach; ?>
									<?php endif; ?>
									</ul>
								</div>	

								<div class="col-6">
									<div class="cont-det">
										<h2><?php the_title(); ?></h2>

										<div class="det-tec-produto">
											<?php if(get_field('codigo')){ ?>
												<span class="item"><strong>Cod.: </strong><?php the_field('codigo'); ?></span>
											<?php } ?>

											<?php if(get_field('embalagem')){ ?>
												<span class="item"><strong>Embalagem: </strong><?php the_field('embalagem'); ?></span>
											<?php } ?>
										</div>

										<?php the_excerpt(); ?>

										<a href="javascript:" title="Solicitar Orçamento" class="btn btn-saiba-mais enviar" id="add-orcamento" nome-prod="<?php the_title(); ?>" cod-prod="<?php the_field('codigo'); ?>">
											<i class="fa fa-paper-plane" aria-hidden="true"></i>
											Solicitar Orçamento
										</a>	

									</div>	
								</div>

								<div class="col-12">
									<div class="cont-det">

										<?php the_content(); ?>

										<?php if(get_field('vantagens')){ ?>
											<h5>Vantagens</h5>
											<p><?php the_field('vantagens'); ?></p>
										<?php } ?>

										<?php if(get_field('aplicacoes')){ ?>
											<h5>Aplicações</h5>
											<p><?php the_field('aplicacoes'); ?></p>
										<?php } ?>

										<?php if(get_field('recomendacoes')){ ?>
											<h5>Recomendação de Uso</h5>
											<p><?php the_field('recomendacoes'); ?></p>
										<?php } ?>

										<?php if(get_field('composicao')){ ?>
											<h5>Composição</h5>
											<p><?php the_field('composicao'); ?></p>
										<?php } ?>

										<?php if(get_field('video')){ ?>
											<div class="tab" id="video-demonstrativo">
												<?php the_field('video'); ?>
											</div>
										<?php } ?>

									</div>
								</div>

							<?php endwhile;
							wp_reset_query();
						?>
					</div>
				</div>
			</div>

		</div>
	</section>

	<?php 
		$posts = get_field('produtos_relacionados');
		if( $posts ): ?>
		
			<section class="box-content produto list-produto prod-relacionado">
				<div class="container">

					<div class="row">
						<div class="col-9">
							
							<h2>Produtos Relacionados</h2>

							<?php
								foreach( $posts as $post):
									setup_postdata($post);

									get_template_part( 'content-produtos-list', 'post' );

								endforeach;
								wp_reset_postdata();
							?>

						</div>
					</div>

				</div>
			</section>
			
		<?php endif;
	?>

<?php get_footer(); ?>

<div class="bg-modal" id="modal-erro">
	<div class="box-modal">
		<div class="modal-conteudo">

			<i class="fa fa-times close-modal" aria-hidden="true"></i>
			<h2>Desculpe!</h2>
			<p class="msg center"></p>

		</div>
	</div>
</div>

<div class="bg-modal" id="modal-orcamento">
	<div class="box-modal">
		<div class="modal-conteudo">

			<i class="fa fa-times close-modal" aria-hidden="true"></i>
			<h2>Lista de Produtos para Orçamento</h2>
			<p class="msg center"></p>

			<div class="content-modal">					
				<table id="confirmar-orcamento">
					<thead>
						<tr>
							<th width="120" class="center">Código</th>
							<th>Produto</th>
							<th width="80" class="center">Qtd.</th>
							<th></th>
						</tr>
					</thead>
					<tbody id="add-linha-orcamento">

						<?php
							if(isset($_SESSION['orcamento'])){
								if(isset($_SESSION['orcamento']) > 0){

									$qtd_cart_orcamento = 0;
									foreach ($_SESSION['orcamento'] as $key => $value) { 
										$qtd_cart_orcamento = $qtd_cart_orcamento+$value['quantidade']; ?>

										<tr id="item-<?php echo $value['id']; ?>">
											<td class="center"><?php echo $value['codigo']; ?></td>
											<td><strong><?php echo $value['nome']; ?></strong></td>
											<td class="qtd" class="center"><input name="qtd<?php echo $value['id']; ?>" placeholder="1" value="<?php echo $value['quantidade']; ?>" type="text"></td>
											<td class="center"><a href="javascript:" class="remove-item" qtd-prod="<?php echo $value['quantidade']; ?>" id-prod="<?php echo $value['id']; ?>"><i class="fa fa-times-circle" aria-hidden="true"></i></a></td>
										</tr>

									<?php }

									if($qtd_cart_orcamento == 0){
										echo '<tr id="qtd-0" class="fixo"><td colspan="4">Nenhum produto adicionado.</td></tr>';
									}else{
										echo '<tr id="qtd-0" class="fixo" style="display: none;"><td colspan="4">Nenhum produto adicionado.</td></tr>';
									}

								}else{
									echo '<tr id="qtd-0" class="fixo"><td colspan="4">Nenhum produto adicionado.</td></tr>';
								}
							}else{
								echo '<tr id="qtd-0" class="fixo"><td colspan="4">Nenhum produto adicionado.</td></tr>';
							}
						?>

					</tbody>
					<tfoot>
						<tr>
							<th></th>
							<th class="right">TOTAL DE PRODUTOS: </th>
							<th class="center" id="qtd_orcamento"><?php echo $qtd_cart_orcamento; ?></th>
							<th></th>
						</tr>
					</tfoot>
				</table>
			</div>

			<div class="dados-cliente row" style="<?php if($qtd_cart_orcamento == 0){ echo 'display: none;'; } ?>">
				<fieldset class="col-4">
					<input type="text" name="nome-orcamento" id="nome-orcamento" placeholder="Nome">
				</fieldset>

				<fieldset class="col-4">
					<input type="text" name="email-orcamento" id="email-orcamento" placeholder="E-mail">
				</fieldset>

				<fieldset class="col-4">
					<input type="text" class="mask-telefone" name="tel-orcamento" id="tel-orcamento" placeholder="Telefone">
				</fieldset>
			</div>

			<a href="javascript:" title="Solicitar Orçamento" id="enviar-orcamento" class="btn orcamento <?php if($qtd_cart_orcamento == 0){ echo 'off'; } ?>">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i> Enviar Orçamento
			</a>
		</div>
	</div>
</div>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/fancybox/fancybox.js"></script>
<script type="text/javascript">
	var qtd_cart_orcamento = '<?php echo $qtd_cart_orcamento; ?>';

	jQuery(document).ready(function() {		
		jQuery('.fancybox').fancybox();

		jQuery('#add-orcamento').click(function() { //alert();
			jQuery('.msg-pedido').html('');

			nome = '<?php the_title(); ?>';
			codigo = '<?php the_field('codigo'); ?>';
			id = '<?php echo $post->ID; ?>';
			item = '';
			<?php
				if(isset($_SESSION['orcamento'])){
					if(isset($_SESSION['orcamento']) > 0){

						$qtd_cart_orcamento = 0;
						foreach ($_SESSION['orcamento'] as $key => $value) {
							$qtd_cart_orcamento = $qtd_cart_orcamento+$value['quantidade'];
						}

					}else{
						$qtd_cart_orcamento = 0;
					}
				}else{
					$qtd_cart_orcamento = 0;
				}
			?>

			/*alert(nome);
			alert(codigo);
			alert(id);
			alert(qtd_cart_orcamento);*/

			jQuery.getJSON("<?php echo get_template_directory_uri(); ?>/add-orcamento.php", { id:id, nome:nome, codigo:codigo }, function(result){		
				if(result=='ok'){
					jQuery('#modal-orcamento .msg').html('Item adicionado com sucesso!');
					item += '<tr id="item-'+id+'">';
						item += '<td class="center">'+codigo+'</td>';
						item += '<td><strong>'+nome+'</strong></td>';
						item += '<td class="qtd" class="center"><input name="qtd'+id+'" placeholder="1" value="1" type="text"></td>';
						item += '<td class="center"><a href="javascript:" class="remove-item" qtd-prod="1" id-prod="'+id+'"><i class="fa fa-times-circle" aria-hidden="true"></i></a></td>';
					item += '</tr>';

					qtd_cart_orcamento = parseInt(qtd_cart_orcamento)+parseInt(1);
					jQuery('#add-linha-orcamento').append(item);
					jQuery('#modal-orcamento').css('display','table');
					jQuery('#qtd_cart_orcamento').html('<span>'+qtd_cart_orcamento+'</span>');
					jQuery('#qtd_orcamento').html(qtd_cart_orcamento);
					jQuery('#qtd-0').hide();

					//alert(qtd_cart_orcamento);

					if(qtd_cart_orcamento > 0){
						jQuery('#enviar-orcamento').removeClass('off');
						jQuery('.dados-cliente').show();
					}
				}else{
					if(result=='ja-existe'){
						jQuery('#modal-erro .msg').html('Este item já foi adicionado à lsita de orçamentos!');
						jQuery('#modal-erro').css('display','table');
					}else{
						jQuery('#modal-erro .msg').html('Não foi possível adicionar esse item!');
						jQuery('#modal-erro').css('display','table');
					}
				}
			});
		});

	});
</script>