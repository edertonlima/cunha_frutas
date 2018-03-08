<?php if(get_page_by_path('central-vendas')->post_title){ ?>
	<div class="sidebar-block central-vendas">
		<h2><?php echo get_page_by_path('central-vendas')->post_title; ?></h2>

		<?php $imagem = wp_get_attachment_image_src( get_post_thumbnail_id(get_page_by_path('central-vendas')->ID), 'medium' ); ?>
		<img src="<?php echo $imagem[0]; ?>" alt="<?php echo get_page_by_path('central-vendas')->post_title; ?>" class="img-sidebar">

		<p><?php echo get_page_by_path('central-vendas')->post_excerpt; ?></p>

		<?php /*<a href="<?php echo get_home_url(); ?>/central-vendas" title="Atendimento" class="mais-item">
			<i class="fa fa-caret-right" aria-hidden="true"></i> Atendimento
		</a>*/?>
	</div>
<?php } ?>