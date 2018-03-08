<div class="col-4">
	<div class="item-produto">
		<?php $imagem = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>

		<?php if($imagem[0]){ ?>
			<a href="<?php the_permalink(); ?>" title="Mais Detalhes" class="img-prod" style="background-image: url('<?php echo $imagem[0]; ?>');">
				<div class="mask"><i class="fa fa-plus" aria-hidden="true"></i></div>
				<img src="<?php echo $imagem[0]; ?>" alt="<?php the_title(); ?>" class="" style="display: none;">
			</a>
		<?php } ?>

		<div class="cont-list">
			<a href="<?php the_permalink(); ?>" title="Mais Detalhes">
				<h4><?php the_title(); ?></h4>
			</a>
			<?php the_excerpt(); ?>

			<span class="embalagem"><?php the_field('embalagem'); ?></span>

			<div class="btn-prod">
				<a href="javascript:" class="btn btn-produto btn-orcamento">Solicitar Orçamento</a>
				<a href="<?php the_permalink(); ?>" title="Mais Detalhes" class="btn btn-produto btn-more"><i class="fa fa-angle-right" aria-hidden="true"></i></a>
			</div>

			<?php /*<div class="review">
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
			</div>*/ ?>

		</div>	
	</div>
</div>