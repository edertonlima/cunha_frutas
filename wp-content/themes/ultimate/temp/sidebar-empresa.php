
<ul class="list-menu">

<?php if(get_page_by_path('empresa')->post_title){ ?>
	<li class="<?php if(is_page('empresa')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/empresa" title="<?php echo get_page_by_path('empresa')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('empresa')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('nossa-equipe')->post_title){ ?>
	<li class="<?php if(is_page('nossa-equipe')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/nossa-equipe" title="<?php echo get_page_by_path('nossa-equipe')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('nossa-equipe')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('logistica')->post_title){ ?>
	<li class="<?php if(is_page('logistica')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/logistica" title="<?php echo get_page_by_path('logistica')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('logistica')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('responsavel-tecnico')->post_title){ ?>
	<li class="<?php if(is_page('responsavel-tecnico')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/responsavel-tecnico" title="<?php echo get_page_by_path('responsavel-tecnico')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('responsavel-tecnico')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('responsabilidade-social')->post_title){ ?>
	<li class="<?php if(is_page('responsabilidade-social')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/responsabilidade-social" title="<?php echo get_page_by_path('responsabilidade-social')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('responsabilidade-social')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('responsabilidade-ambiental')->post_title){ ?>
	<li class="<?php if(is_page('responsabilidade-ambiental')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/responsabilidade-ambiental" title="<?php echo get_page_by_path('responsabilidade-ambiental')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('responsabilidade-ambiental')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('projeto-ecoeter')->post_title){ ?>
	<li class="<?php if(is_page('projeto-ecoeter')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/projeto-ecoeter" title="<?php echo get_page_by_path('projeto-ecoeter')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('projeto-ecoeter')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('representantes')->post_title){ ?>
	<li class="<?php if((is_archive('representantes')) and (!is_category('noticias'))){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/representantes" title="<?php echo get_page_by_path('representantes')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('representantes')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('qualidade')->post_title){ ?>
	<li class="<?php if(is_page('qualidade')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/qualidade" title="<?php echo get_page_by_path('qualidade')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('qualidade')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('area-de-atuacao')->post_title){ ?>
	<li class="<?php if(is_page('area-de-atuacao')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/area-de-atuacao" title="<?php echo get_page_by_path('area-de-atuacao')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('area-de-atuacao')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('imprensa')->post_title){ ?>
	<li class="<?php if(is_page('imprensa')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/imprensa" title="<?php echo get_page_by_path('imprensa')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('imprensa')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('trabalhe-conosco')->post_title){ ?>
	<li class="<?php if(is_page('trabalhe-conosco')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/trabalhe-conosco" title="<?php echo get_page_by_path('trabalhe-conosco')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('trabalhe-conosco')->post_title; ?>
		</a>
	</li>
<?php } ?>

<?php if(get_page_by_path('fale-conosco')->post_title){ ?>
	<li class="<?php if(is_page('fale-conosco')){ echo 'active'; } ?>">
		<a href="<?php echo get_home_url(); ?>/fale-conosco" title="<?php echo get_page_by_path('fale-conosco')->post_title; ?>">
			<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo get_page_by_path('fale-conosco')->post_title; ?>
		</a>
	</li>
<?php } ?>

</ul>