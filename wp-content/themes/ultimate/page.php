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

					<?php if(get_field('missao') or get_field('visao') or get_field('valores')){ ?>
						<div class="content-txt">

							<?php if(get_field('missao')){ ?>
								<div class="col-4">
									<h4>Missão</h4>
									<p><?php the_field('missao'); ?></p>
								</div>
							<?php } ?>

							<?php if(get_field('visao')){ ?>
								<div class="col-4">
									<h4>Visão</h4>
									<p><?php the_field('visao'); ?></p>
								</div>
							<?php } ?>

							<?php if(get_field('valores')){ ?>
								<div class="col-4">
									<h4>Valores</h4>
									<p><?php the_field('valores'); ?></p>
								</div>
							<?php } ?>
						</div>
					<?php } ?>
					
				</div>
			</div>

		</div>
	</section>

<?php get_footer(); ?>