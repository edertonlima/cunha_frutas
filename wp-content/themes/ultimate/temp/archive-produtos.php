<?php get_header(); ?>

<section class="box-content produto list-produto">
	<div class="container">

		<div class="row">
			<div class="col-12">

				<h2>PRODUTOS
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

				<?php paginacao(); ?>
			</div>

			<div class="col-3 sidebar">

				<?php include 'sidebar-categorias.php'; ?>

			</div>
		</div>

	</div>
</section>

<?php get_footer(); ?>