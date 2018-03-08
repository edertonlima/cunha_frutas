<?php get_header(); ?>

	<?php //$terms = wp_get_post_terms( $post->ID, $post->post_type.'_taxonomy' ); //var_dump($terms); ?>
	<?php $categoria_id = get_queried_object()->term_id; //var_dump($term); ?>
	<?php $post_type = get_post_type_object( $post->post_type ); ?>

	<?php //$taxonomy = get_queried_object(); var_dump($taxonomy) ?>

	<section class="box-content produto list-produto">
		<div class="container">

			<div class="row">
				<div class="col-12">

					<h2>
						<a href="<?php echo get_home_url(); ?>/produtos" title="PRODUTOS">
							PRODUTOS 
						</a>
						<span>
							<i class="fa fa-angle-right" aria-hidden="true"></i>
							<?php echo single_term_title(); ?>
						</span>

						<?php 
							if((isset($_SESSION['id'])) and ($_SESSION['id'] != '')){ ?>
								<a href="javascript: logOff();" class="logOff" title="Sair">
									Sair <i class="fa fa-sign-out" aria-hidden="true"></i>
								</a>
							<?php }
						?>
					</h2>

				</div>

				<div class="col-9">
					<?php if(have_posts()){ ?>
					<div class="row">
						<?php
							
							while ( have_posts() ) : the_post(); 

								get_template_part( 'content-produtos-list', 'post' );

							endwhile;
							wp_reset_query();
							
						?>
					</div>
					<?php }else{ ?>
						<h3><p>Nenhum produto encontrado.</p></h3>
					<?php } ?>
				</div>

				<div class="col-3 sidebar">
					
					<?php include 'sidebar-categorias.php'; ?>
					
				</div>
			</div>

		</div>
	</section>

<?php get_footer(); ?>