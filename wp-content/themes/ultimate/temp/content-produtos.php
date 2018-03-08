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
		<h3><?php the_title(); ?></h3>

		<div class="review">
			<?php 
				if( have_rows('avaliacao') ) {

					$avaliacoes = get_field('avaliacao' );
					foreach($avaliacoes as $avaliacao){ 
						$nota[] = $avaliacao['nota'];
					}

					$qtd_estrela = array_sum($nota) / count(array_filter($nota)); 

					for($i=1; $i <= 5; $i++){
						if($i <= $qtd_estrela){ ?>

							<i class="fa fa-star" aria-hidden="true"></i>

						<?php }else{ ?>

							<i class="fa fa-star off" aria-hidden="true"></i>

						<?php }
					}

				}else{

					for($i=1; $i <= 5; $i++){ ?>

						<i class="fa fa-star off" aria-hidden="true"></i>

					<?php }
				}
			?>

			<span>
				<?php 
					if( have_rows('avaliacao') ) {

						if(count($avaliacoes) == 1){
							echo '1 avaliação';
						}else{
							echo count($avaliacoes).' avaliações';
						}

					}else{

						echo '0 avaliações';
						
					}
				?>				
			</span>
		</div>

		<div class="det-tec-produto">
			<?php if(get_field('codigo')){ ?>
				<span class="item"><strong>Codigo do produto: </strong><?php the_field('codigo'); ?></span>
			<?php } ?>

			<?php if(get_field('embalagem')){ ?>
				<span class="item"><strong>Embalagem: </strong><?php the_field('embalagem'); ?></span>
			<?php } ?>
		</div>

		<?php the_excerpt(); ?>

		<a href="javascript:" title="Solicitar Orçamento" class="btn pedido" id="add-orcamento" nome-prod="<?php the_title(); ?>" cod-prod="<?php the_field('codigo'); ?>">
			<i class="fa fa-paper-plane" aria-hidden="true"></i>
			Solicitar Orçamento
		</a>

		<?php 
			$terms = wp_get_post_terms( $post->ID, $post->post_type.'_taxonomy' );
			$field_cat = 'produtos_taxonomy_'.$terms[0]->term_id;

			if(get_field('normas', $field_cat)){ ?>
				<a href="<?php the_field('normas', $field_cat); ?>" class="fancybox normas" data-fancybox="norma"><i class="fa fa-file-text-o" aria-hidden="true"></i> Normas</a>
			<?php }
		?>		

	</div>	
</div>

<div class="col-12">
	<div class="cont-det">
		
		<nav class="nav-tab">
			<ul>
				<li class="active"><a href="javascript:" rel="#descricao" title="Descrição"><h2>Descrição</h2></a></li>

				<?php if( have_rows('avaliacao') ): ?>
					<li><a href="javascript:" rel="#avaliacoes" title="Avaliações"><h2>Avaliações</h2></a></li>
				<?php endif; ?>

				<?php if(get_field('video')){ ?>
					<li><a href="javascript:" rel="#video-demonstrativo" title="Vídeo Demonstrativo"><h2>Vídeo Demonstrativo</h2></a></li>
				<?php } ?>
			</ul>
		</nav>
		

		<div class="content-tab">
			<div class="tab active" id="descricao">
				<?php the_content(); ?>

				<?php if(get_field('vantagens')){ ?>
					<h3>Vantagens</h3>
					<p><?php the_field('vantagens'); ?></p>
				<?php } ?>

				<?php if(get_field('aplicacoes')){ ?>
					<h3>Aplicações</h3>
					<p><?php the_field('aplicacoes'); ?></p>
				<?php } ?>

				<?php if(get_field('recomendacoes')){ ?>
					<h3>Recomendação de Uso</h3>
					<p><?php the_field('recomendacoes'); ?></p>
				<?php } ?>

				<?php if(get_field('composicao')){ ?>
					<h3>Composição</h3>
					<p><?php the_field('composicao'); ?></p>
				<?php } ?>
			</div>

			<?php if( have_rows('avaliacao') ): ?>
				<div class="tab" id="avaliacoes">				
						
					<ul class="avaliacoes">
						<?php while ( have_rows('avaliacao') ) : the_row(); ?>

							<li>
								<?php $image = get_sub_field('foto'); ?>
								<?php echo wp_get_attachment_image( $image, 'thumbnail' ); ?>	

								<div class="cont-avaliacao">
									<i class="fa fa-quote-left" aria-hidden="true"></i>
									<p><?php the_sub_field('depoimento'); ?></p>
									<h3><?php the_sub_field('nome'); ?></h3>
								</div>
							</li>

						<?php endwhile; ?>
					</ul>
					
				</div>
			<?php endif; ?>

			<?php if(get_field('video')){ ?>
				<div class="tab" id="video-demonstrativo">
					<?php the_field('video'); ?>
				</div>
			<?php } ?>
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

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.nav-tab a').click(function(){
			jQuery('.nav-tab li').removeClass('active');
			jQuery(this).parent().addClass('active');

			jQuery('.content-tab .tab').removeClass('active');
			jQuery(jQuery(this).attr('rel')).addClass('active');
		});
	});
</script>