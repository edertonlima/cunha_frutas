<?php get_header(); ?>

	<div class="main-title" style="">
		<div class="container">
			<h3 class="titulo">PRODUTOS</h3>
			<p class="subtitulo">
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

					<h2>

					</h2>

				</div>

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

<script type="text/javascript">
	jQuery('.img-prod').each(function(){
		jQuery(this).height(jQuery('img',this).height());
	});
</script>