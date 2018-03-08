<?php query_posts(
	array(
		'post_type' => 'post',
		'posts_per_page' => 3
	)
); ?>

	<div class="<?php if(!is_single()){ echo 'sidebar-block'; } ?> noticias">
		<?php if(is_single()){ ?>
			<h2>ÚLTIMAS NOTÍCIAS</h2>
		<?php }else{ ?>
			<h2>NOTÍCIAS</h2>
		<?php } ?>

		<?php if(!have_posts()){ ?>
			
			<p>Nenhuma notícia encontrada.</p>

		<?php }else{ ?>

			<ul class="list-noticias">
				<?php while ( have_posts() ) : the_post(); 
					get_template_part( 'content-noticias-list', 'post' );
				endwhile;
				wp_reset_query(); ?>
			</ul>

			<?php if(!is_category()){ ?>
				<a href="<?php echo get_home_url(); ?>/noticias" title="Mais Notícias" class="mais-item">
					<i class="fa fa-caret-right" aria-hidden="true"></i> Mais Notícias
				</a>
			<?php } ?>

		<?php } ?>
	</div>