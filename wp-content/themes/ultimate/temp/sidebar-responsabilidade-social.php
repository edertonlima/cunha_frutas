<?php if(get_page_by_path('responsabilidade-social')->post_title){ ?>
	<div class="sidebar-block responsabilidade-social">
		<h2><?php echo get_page_by_path('responsabilidade-social')->post_title; ?></h2>

		<?php $imagem = wp_get_attachment_image_src( get_post_thumbnail_id(get_page_by_path('responsabilidade-social')->ID), 'medium' ); ?>
		<img src="<?php echo $imagem[0]; ?>" alt="<?php echo get_page_by_path('responsabilidade-social')->post_title; ?>" class="img-sidebar">

		<p><?php echo get_page_by_path('responsabilidade-social')->post_excerpt; ?></p>

		<a href="<?php echo get_home_url(); ?>/responsabilidade-social" title="Mais Notícias" class="mais-item">
			<i class="fa fa-caret-right" aria-hidden="true"></i> Saiba Mais
		</a>
	</div>
<?php } ?>