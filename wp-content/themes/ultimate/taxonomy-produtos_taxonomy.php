<?php get_header(); ?>
<?php $categoria_id = get_queried_object()->term_id; //var_dump(get_queried_object()); ?>
<?php $post_type = get_post_type_object( $post->post_type ); ?>

	<div class="main-title" style="">
		<div class="container">
			<span class="categoria"><a href="<?php echo get_home_url(); ?>/produtos" title="PRODUTOS">PRODUTOS</a></span>
			<h3 class="titulo"><?php echo single_term_title(); ?></h3>
			<p class="subtitulo">
				<?php echo get_queried_object()->description; ?>

				<?php 
					if((isset($_SESSION['id'])) and ($_SESSION['id'] != '')){ ?>
						<a href="javascript: logOff();" class="logOff" title="Sair">
							Sair <i class="fa fa-sign-out" aria-hidden="true"></i>
						</a>
					<?php }
				?>
			</p>
		</div>
	</div>

	<section class="box-content no-padding-top produto list-produto">
		<div class="container">

			<div class="row">
				<div class="col-12">
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

					<?php paginacao(); ?>
				</div>
			</div>

		</div>
	</section>

<?php get_footer(); ?>