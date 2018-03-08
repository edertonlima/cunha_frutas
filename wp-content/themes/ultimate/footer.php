<footer class="footer">
	<div class="container">

		<div class="row">
			<div class="col-6">
				
				<a href="<?php echo get_home_url(); ?>" title="<?php the_field('titulo', 'option'); ?>">
					<img src="<?php echo get_template_directory_uri(); ?>/assets/images/logo-br.png" alt="<?php the_field('titulo', 'option'); ?>">
				</a>
				<p>Ut enim ad minim veniam, quis nostrud cittion ullamco laboris nisi ut aliquip cosquat uis aute irure dolor.</p>

				<div class="info-header info-contato">
					<div class="item-info-header">
						<i class="fa  fa-headphones"></i>
						<span class="title">Fale Conosco</span>
						<span class="subtitle">+55 47 3344-1697</span>
					</div>

					<div class="item-info-header">
						<i class="fa  fa-clock-o"></i>
						<span class="title">Atendimento</span>
						<span class="subtitle">08:00 - 18:00</span>
					</div>

					<div class="item-info-header escreva">
						<i class="fa  fa-envelope-o"></i>
						<span class="title">Escreva-nos</span>
						<span class="subtitle">valdeir.repres@hotmail.com</span>
					</div>

					<div class="item-info-header escreva">
						<i class="fa fa-map-marker"></i>
						<span class="title">Endereço</span>
						<span class="subtitle">Rua Vereador Nestor dos Santos, 1155<br>Cordeiros, Itajaí, SC</span>
					</div>
				</div>

			</div>

			<div class="col-3 categorias-produtos">
				<h3>MENU</h3>

				<a href="<?php echo get_home_url(); ?>/quem-somos" class="link-footer"><i class="icons fa fa-circle"></i>Quem Somos</a>
				<?php
					$my_wp_query = new WP_Query();
					$all_wp_pages = $my_wp_query->query(array('post_type' => 'page', 'posts_per_page' => '-1'));
					$paginas = get_page_children( get_page_by_path('quem-somos')->ID, $all_wp_pages );

					if(count($paginas)){
						foreach ($paginas as $key => $pagina) { ?>

							<a href="<?php echo get_permalink($pagina->ID); ?>" class="link-footer" title="<?php echo $pagina->post_title; ?>">
								<i class="icons fa fa-circle"></i><?php echo $pagina->post_title; ?>
							</a>

						<?php }
					}
				?>

				<a href="<?php echo get_home_url(); ?>/produtos" class="link-footer"><i class="icons fa fa-circle"></i>Produtos</a>
				<a href="<?php echo get_home_url(); ?>/trabalhe-conosco" class="link-footer"><i class="icons fa fa-circle"></i>Trabalhe Conosco</a>
				<a href="<?php echo get_home_url(); ?>/fale-conosco" class="link-footer"><i class="icons fa fa-circle"></i>Fale Conosco</a>
			</div>

			<div class="col-3 categorias-produtos">
				<h3>PRODUTOS</h3>
				<?php
					$args = array(
					    'taxonomy'      => 'produtos_taxonomy',
					    'parent'        => 0,
					    'orderby'       => 'name',
					    'order'         => 'ASC',
					    'hierarchical'  => 1,
					    'pad_counts'    => true,
					    'hide_empty'    => 0
					);
					$categories = get_categories( $args );
					foreach ( $categories as $categoria ){ ?>
							<a href="<?php echo get_term_link($categoria->term_id); ?>" class="link-footer" title="<?php echo $categoria->name; ?>">
								<i class="icons fa fa-circle"></i> <?php echo $categoria->name; ?>
							</a>
						<?php
					}
				?>
			</div>
		</div>
	</div>
	
	<div class="copy">
		<div class="container">
			<p><i class="fa fa-copyright" aria-hidden="true"></i> <?php echo date('Y').' '; the_field('titulo', 'option'); ?> - Todos os direitos reservados.</p>
			<?php if( have_rows('redes_sociais','option') ): ?>
				<div class="redes">						
					<?php while ( have_rows('redes_sociais','option') ) : the_row(); ?>
						<a href="<?php the_sub_field('url','option'); ?>" title="<?php the_sub_field('nome','option'); ?>" target="_blank">
							<?php the_sub_field('icone','option'); ?>
						</a>
					<?php endwhile; ?>
				</div>
			<?php endif; ?>
		</div>
	</div>
</footer>