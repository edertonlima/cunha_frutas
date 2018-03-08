<?php get_header(); ?>

	<section class="box-content empresa">
		<div class="container">

			<div class="row">
				<div class="col-12">
					<h2>
						Cartao bndes
					</h2>
				</div>

				<div class="col-8">

					<?php
						while ( have_posts() ) : the_post(); 
							
							get_template_part( 'content', 'post' );

						endwhile;
						wp_reset_query();
					?>

					<?php include 'sidebar-cartao-bndes.php'; ?>
					
				</div>

				<div class="col-4 sidebar">

					<?php include 'sidebar-empresa.php'; ?>
					<?php include 'sidebar-noticias.php'; ?>

				</div>
			</div>

		</div>
	</section>

<?php get_footer(); ?>