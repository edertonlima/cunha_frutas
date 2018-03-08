<?php if(get_page_by_path('cartao-bndes')->post_title){ ?>	
	<div class="sidebar-block cartao-bndes">
		<div class="row">
			<div class="col-6">

				<?php if(!is_page('cartao-bndes')){ ?>
					<h2><?php echo get_page_by_path('cartao-bndes')->post_title; ?></h2>
				<?php } ?>

				<?php if( have_rows('itens_caracteristica',get_page_by_path('cartao-bndes')->ID) ): ?>
					
					<ul class="itens-caracteristica">
						<?php while ( have_rows('itens_caracteristica',get_page_by_path('cartao-bndes')->ID) ) : the_row(); ?>
							<li><i class="fa fa-caret-right" aria-hidden="true"></i> <?php the_sub_field('texto'); ?></li>
						<?php endwhile; ?>
					</ul>

				<?php endif; ?>

				<p><?php echo get_page_by_path('cartao-bndes')->post_excerpt; ?></p>
			</div>

			<div class="col-6">
				<?php $imagem = wp_get_attachment_image_src( get_post_thumbnail_id(get_page_by_path('cartao-bndes')->ID), 'medium' ); ?>
				<img src="<?php echo $imagem[0]; ?>" alt="<?php echo get_page_by_path('cartao-bndes')->post_title; ?>" class="img-sidebar">	

				<?php if(!is_page('cartao-bndes')){ ?>
					<a href="<?php echo get_home_url(); ?>/cartao-bndes" title="Saiba Mais" class="mais-item">
						<i class="fa fa-caret-right" aria-hidden="true"></i> Saiba Mais
					</a>
				<?php } ?>
			</div>
		</div>
	</div>
<?php } ?>