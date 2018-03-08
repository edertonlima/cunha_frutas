<?php get_header(); ?>

<section class="box-content produto list-produto">
	<div class="container">

		<div class="row">
			<div class="col-12">

				<h2>NOTÍCIAS</h2>

			</div>

			<div class="col-8">
				<div class="row">

					<?php
						if(have_posts()){
							while ( have_posts() ) : the_post(); 
								
								get_template_part( 'content-category', 'post' );

							endwhile;
							wp_reset_query();
						}else{ ?>

							<div class="col-12">
								<h4>
									<br><br>
									<p>Nenhuma noticia encontrada.</p>
								</h4>
							</div>

						<?php }
					?>
				</div>
			</div>

			<div class="col-4 sidebar">

				<?php include 'sidebar-empresa.php'; ?>
				<?php include 'sidebar-projeto-ecoeter.php'; ?>
				<?php include 'sidebar-responsabilidade-social.php'; ?>

			</div>
		</div>

	</div>
</section>

<?php get_footer(); ?>

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.nav ul li.menu-noticias').addClass('active');
	});
</script>