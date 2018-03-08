<?php session_start(); ?>

<!DOCTYPE html>
<html lang="pt-br">
<head>

<?php 
	$titulo_princ = get_field('titulo', 'option');
	$descricao_princ = get_field('descricao', 'option');
	
	$keywords = get_field('palavras_chave', 'option');
	if(get_field('keywords')){
		$keywords = $keywords.', '.get_field('keywords');
	}

	$titulo = get_the_title();
	$descricao = get_the_excerpt();
	
	$imagem_princ = get_field('imagem_principal', 'option');
	$url = get_home_url();
	$imgPage = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), '' );

	if(is_tax()){
		$terms = get_queried_object();
		$titulo = $terms->name;
		$descricao = $terms->description;
		$imagem = get_field('imagem_listagem',$terms->taxonomy.'_'.$terms->term_id);
		$url = get_term_link($terms->term_id);
	}

	if(is_archive()){
		$titulo = get_field('titulo_pagina','option');
		$descricao = get_field('descricao_pagina','option');
		$imagem = get_field('imagem_pagina','option');
		$url = $url.'/produtos';
	}

	if(is_single()){
		$titulo = get_the_title();
		$descricao = get_the_excerpt();
		
		if($imgPage[0] != ''){
			$imagem = $imgPage[0];	
		}			
		$url = get_the_permalink();
	}

	if(($titulo == '') or ($titulo == 'Home')){
		$titulo = $titulo_princ;
	}else{
		$titulo = $titulo.' - '.$titulo_princ;
	}
	
	if($descricao == ''){
		$descricao = $descricao_princ;
	}

	$autor = 'ULTIMATE! tecnologia e design, atendimento@ultimate.com.br';
?>

<meta name="viewport" content="width=device-width, initial-scale=1" />
<link rel="shortcut icon" href="<?php the_field('favicon', 'option'); ?>" type="image/x-icon" />
<link rel="icon" href="<?php the_field('favicon', 'option'); ?>" type="image/x-icon" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="content-language" content="pt" />
<meta name="rating" content="General" />
<meta name="description" content="<?php echo $descricao; ?>" />
<meta name="keywords" content="<?php echo $keywords; ?>" />
<meta name="robots" content="index,follow" />
<meta name="author" content="<?php echo $autor; ?>" />
<meta name="language" content="pt-br" />
<meta name="title" content="<?php echo $titulo; ?>" />

<!-- SOCIAL META -->
<meta itemprop="name" content="<?php echo $titulo; ?>" />
<meta itemprop="description" content="<?php echo $descricao; ?>" />
<meta itemprop="image" content="<?php echo $imagem; ?>" />

<html itemscope itemtype="<?php echo $url; ?>" />
<link rel="image_src" href="<?php echo $imagem; ?>" />
<link rel="canonical" href="<?php echo $url; ?>" />

<meta property="og:type" content="website">
<meta property="og:title" content="<?php echo $titulo; ?>" />
<meta property="og:type" content="article" />
<meta property="og:description" content="<?php echo $descricao; ?>" />
<meta property="og:image" content="<?php echo $imagem; ?>" />
<meta property="og:url" content="<?php echo $url; ?>" />
<meta property="og:site_name" content="<?php echo $titulo_princ; ?>" />
<meta property="fb:admins" content="<?php echo $autor; ?>" />
<meta property="fb:app_id" content="1205127349523474" /> 

<meta name="twitter:card" content="summary" />
<meta name="twitter:url" content="<?php echo $url; ?>" />
<meta name="twitter:title" content="<?php echo $titulo; ?>" />
<meta name="twitter:description" content="<?php echo $descricao; ?>" />
<meta name="twitter:image" content="<?php echo $imagem; ?>" />
<!-- SOCIAL META -->

<title><?php echo $titulo; ?></title>

<!-- CSS -->
<link rel="stylesheet" type="text/css" href="<?php echo get_template_directory_uri(); ?>/assets/css/style.css" media="screen" />
<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/owl.carousel.min.css" type="text/css" media="screen" />

<?php /*if(is_single('minha-area')){ ?>
	<link rel="stylesheet" href="<?php echo get_template_directory_uri(); ?>/assets/css/jquery.dataTables.min.css" type="text/css" media="screen" />
<?php } */?>

<!-- JQUERY -->
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/jquery.min.js"></script>
<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/bootstrap.min.js"></script>


<script type="text/javascript">
	jQuery.noConflict();

	jQuery(document).ready(function(){

		jQuery('.menu-mobile').click(function(){
			if(jQuery(this).hasClass('active')){
				jQuery('.header__navigation').removeClass('active');
				jQuery(this).removeClass('active');
				jQuery('.header').removeClass('active');
			}else{
				jQuery('.header__navigation').addClass('active');
				jQuery(this).addClass('active');
				jQuery('.header').addClass('active');
			}
		});

		scroll_body = jQuery(window).scrollTop();
		if(scroll_body > 400){
			jQuery('.header').addClass('scroll_menu');
		}
	});	

	jQuery(window).load(function(){
		if(((jQuery('body').height())+400) < jQuery(window).height()){
			jQuery('.footer').css({position: 'absolute', bottom: '0px'});
		}else{
			jQuery('.footer').css({position: 'relative'});
		}
	});
	
	jQuery(window).resize(function(){
		jQuery('.menu-mobile').removeClass('active');
		jQuery('.header').removeClass('active');
		jQuery('.header__navigation').removeClass('active');

		if(((jQuery('body').height())+400) < jQuery(window).height()){
			jQuery('.footer').css({position: 'absolute', bottom: '0px'});
		}else{
			jQuery('.footer').css({position: 'relative'});
		}
	});

	jQuery(window).scroll(function(){
		scroll_body = jQuery(window).scrollTop();
		if(scroll_body > 400){
			jQuery('.header').addClass('scroll_menu');
		}else{
			jQuery('.header').removeClass('scroll_menu');
		}
	});
</script>

<!-- CHAT -->
<?php 
	if(get_field('chat', 'option')){
		the_field('chat', 'option');
	}
?>
<!-- CHAT -->

</head>
<body <?php body_class(); ?>>

	<!-- ANALYTICS -->
	<?php if(get_field('analytics', 'option')){ ?>
		<script>
			(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
			(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
			m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
			})(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

			ga('create', '<?php the_field('analytics', 'option'); ?>', 'auto');
			ga('send', 'pageview');
		</script>
	<?php } ?>
	<!-- ANALYTICS -->

	<div class="top-header">
		<div class="container">
			<div class="menu-top-menu">
				<a href="<?php echo get_home_url(); ?>/cadastro" class="destaque">Cadastrar-se</a>
				<a href="<?php echo get_home_url(); ?>/minha-area">Entrar</a>
			</div>	
		</div>
	</div>

	<header class="header">		
		<div class="container">

			<a href="javascript:" class="menu-mobile"><span><em>X</em></span></a>

			<h1>
				<a href="<?php echo get_home_url(); ?>" title="<?php the_field('titulo', 'option'); ?>">
					<img src="<?php the_field('logo_header', 'option'); ?>" alt="<?php the_field('titulo', 'option'); ?>">
				</a>
			</h1>

			<?php /*
			<nav class="nav">
				<ul class="menu-principal">
					<li class="menu-empresa">
						<a href="<?php echo get_home_url(); ?>/empresa" title="EMPRESA">EMPRESA</a>
					</li>

					<li class="menu-produtos">
						<a href="<?php echo get_home_url(); ?>/produtos" title="PRODUTOS">PRODUTOS</a>

						<ul class="submenu">
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

									<li class="<?php if($categoria->term_id == $categoria_id){ echo 'active'; } ?>">
										<a href="<?php echo get_term_link($categoria->term_id); ?>" title="<?php echo $categoria->name; ?>">
											<?php echo $categoria->name; ?>
										</a>
									</li>

									<?php
								}
							?>
						</ul>
					</li>

					<li class="menu-qualidade">
						<a href="<?php echo get_home_url(); ?>/qualidade" title="QUALIDADE">QUALIDADE</a>
					</li>

					<li class="menu-area-de-atuacao">
						<a href="<?php echo get_home_url(); ?>/area-de-atuacao" title="ÁREA DE ATUAÇÃO">ÁREA DE ATUAÇÃO</a>
					</li>

					<li class="menu-noticias">
						<a href="<?php echo get_home_url(); ?>/noticias" title="NOTÍCIAS">NOTÍCIAS</a>
					</li>

					<li class="menu-fale-conosco">
						<a href="<?php echo get_home_url(); ?>/fale-conosco" title="FALE CONOSCO">FALE CONOSCO</a>
					</li>

					<li class="menu-minha-area">
						<a href="<?php echo get_home_url(); ?>/minha-area" title="MINHA ÁREA">MINHA ÁREA</a>
					</li>
				</ul>
			</nav> */?>

			<div class="info-header">
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

				<div class="item-info-header">
					<i class="fa  fa-envelope-o"></i>
					<span class="title">Escreva-nos</span>
					<span class="subtitle">valdeir.repres@hotmail.com</span>
				</div>
			</div>

			<div class="header__navigation  js-sticky-offset">
				<nav class="collapse  navbar-collapse" role="navigation" aria-label="Main Menu" id="cargopress-navbar-collapse">
					<ul id="menu-main-menu" class="main-navigation  js-main-nav  js-dropdown" role="menubar">
						<li class="<?php if(is_front_page()){ echo 'active'; } ?>"><a href="<?php echo get_home_url(); ?>">Home</a></li>
						<li class="<?php if(is_page(array( 'quem-somos'))){ echo 'active'; } ?>">
							<a href="<?php echo get_home_url(); ?>/quem-somos">Quem Somos <i class="fa fa-sort-desc"></i></a>
							<ul>

								<?php
									$my_wp_query = new WP_Query();
									$all_wp_pages = $my_wp_query->query(array('post_type' => 'page', 'posts_per_page' => '-1'));
									$paginas = get_page_children( get_page_by_path('quem-somos')->ID, $all_wp_pages );

									$cont_page = 0;
									foreach ($paginas as $key => $pagina) { ?>

										<li><a href="<?php echo get_permalink($pagina->ID); ?>" title="<?php echo $pagina->post_title; ?>"><?php echo $pagina->post_title; ?></a></li>

									<?php }
								?>

							</ul>
						</li>
						<li class="<?php if((is_post_type_archive('produtos')) or (is_tag()) or (is_tax('produtos_taxonomy')) or (is_singular('produtos'))){ echo 'active'; } ?>">
							<a href="<?php echo get_home_url(); ?>/produtos">Produtos <i class="fa fa-sort-desc"></i></a>
							<ul>
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

										<li class="<?php if($categoria->term_id == $categoria_id){ echo 'active'; } ?>">
											<a href="<?php echo get_term_link($categoria->term_id); ?>" title="<?php echo $categoria->name; ?>">
												<?php echo $categoria->name; ?>
											</a>
										</li>

										<?php
									}
								?>
								<?php /*<li><a href="javascript:" class="link-footer">Pescados Nacionais</a></li>
								<li><a href="javascript:" class="link-footer">Pescados Importados</a></li>
								<li><a href="javascript:" class="link-footer">Filets</a></li>
								<li><a href="javascript:" class="link-footer">Frutos do Mar</a></li>
								<li><a href="javascript:" class="link-footer">Em Postas</a></li>
								<li><a href="javascript:" class="link-footer">Defumados</a></li>
								<li><a href="javascript:" class="link-footer">Bacalhau</a></li>
								<li><a href="javascript:" class="link-footer">Peixes Inteiros</a></li>*/ ?>
							</ul>
						</li>
						<li class="<?php if(is_page(array( 'fale-conosco', 'trabalhe-conosco' ))){ echo 'active'; } ?>">
							<a href="<?php echo get_home_url(); ?>/fale-conosco">Fale Conosco <i class="fa fa-sort-desc"></i></a>
							<ul>
								<li><a href="<?php echo get_home_url(); ?>/trabalhe-conosco">Trabalhe Conosco</a></li>
							</ul>
						</li>
					</ul>

					<div class="redes">
						<a href="javascript:"><i class="fa fa-facebook"></i></a>
						<a href="javascript:"><i class="fa fa-instagram"></i></a>
					</div>
				</nav>
			</div>

		</div>

		<?php /*
		<dib class="box-busca">
			<div class="link">
				<a href="<?php echo get_home_url(); ?>" title="Página inicial">Página inicial</a>
				<span>|</span>
				<a href="<?php echo get_home_url(); ?>/minha-area" title="Minha área">Minha área</a>
			</div>

			<form class="busca-header" role="search" method="get" id="searchform" action="<?php echo get_home_url(); ?>">
				<fieldset>
					<input value="" name="s" id="s" type="text" placeholder="BUSCA" />
					<button type="submit">OK</button>
				</fieldset>
			</form>

			<a href="javascript:" class="cart-orcamento">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				<div id="qtd_cart_orcamento">
					<?php
						if(isset($_SESSION['orcamento'])){
							if(isset($_SESSION['orcamento']) > 0){
								$qtd_cart_orcamento = 0;
								foreach ($_SESSION['orcamento'] as $key => $value) {
									$qtd_cart_orcamento = $qtd_cart_orcamento+$value['quantidade'];
								}

								if($qtd_cart_orcamento){
									echo '<span>'.$qtd_cart_orcamento.'</span>';
								}
							}
						}
					?>
				</div>
			</a>
		</dib> */?>
	</header>

<?php
/*	session_start();
	unset($_SESSION['orcamento']);
*/?>