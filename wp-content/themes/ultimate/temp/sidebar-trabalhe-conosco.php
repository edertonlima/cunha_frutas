<?php if(get_page_by_path('trabalhe-conosco')->post_title){ ?>
	<div class="sidebar-block trabalhe-conosco">
		<h2><?php echo get_page_by_path('trabalhe-conosco')->post_title; ?></h2>

		<?php $imagem = wp_get_attachment_image_src( get_post_thumbnail_id(get_page_by_path('trabalhe-conosco')->ID), 'medium' ); ?>
		<img src="<?php echo $imagem[0]; ?>" alt="<?php echo get_page_by_path('trabalhe-conosco')->post_title; ?>" class="img-sidebar">

		<p><?php echo get_page_by_path('trabalhe-conosco')->post_excerpt; ?></p>

		<a href="<?php echo get_home_url(); ?>/trabalhe-conosco" title="Preencha o Formulário" class="mais-item">
			<i class="fa fa-caret-right" aria-hidden="true"></i> Preencha o Formulário
		</a>
	</div>
<?php } ?>