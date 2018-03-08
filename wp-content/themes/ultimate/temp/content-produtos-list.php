<div class="col-4">
	<a href="<?php the_permalink(); ?>" class="item-produto">
		<?php $imagem = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>
		<img src="<?php echo $imagem[0]; ?>" alt="<?php the_title(); ?>" class="">

		<div class="cont-list">
			<h4><?php the_title(); ?></h4>

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

		</div>	
	</a>
</div>