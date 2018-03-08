<?php
	global $wp_query;
	$search = $wp_query->posts;
	foreach ($search as $key => $value) {

		if($value->post_type == 'produtos'){
			$produtos[] = $value;
		}

		if($value->post_type == 'post'){
			$blog[] = $value;
		}

		if($value->post_type == 'representantes'){
			$representantes[] = $value;
		}

		if($value->post_type == 'page'){
			$page[] = $value;
		}

	}
?>

<?php get_header(); ?>

<section class="box-content">
	<div class="container">

		<div class="row">
			<div class="col-12">

				<h2>SUA BUSCA
					<span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
						<?php echo $_GET['s']; ?>
					</span>
					<?php 
						if((isset($_SESSION['id'])) and ($_SESSION['id'] != '')){ ?>
							<a href="javascript: logOff();" class="logOff" title="Sair">
								Sair <i class="fa fa-sign-out" aria-hidden="true"></i>
							</a>
						<?php }
					?>
				</h2>

			</div>

			<div class="col-8">

				<?php
					if($wp_query->found_posts){
						if($produtos){ ?>		

							<h2 class="sub-titulo">Produtos</h2>

							<div class="row produto list-produto">

								<?php foreach ($produtos as $key => $value) { ?>
									<div class="col-4 result-busca produto">
										<a href="<?php the_permalink($value->ID); ?>" class="item-produto">
											<?php $imagem = wp_get_attachment_image_src( get_post_thumbnail_id($value->ID), 'thumbnail' ); ?>
											<img src="<?php echo $imagem[0]; ?>" alt="<?php the_title(); ?>" class="">

											<div class="cont-list">
												<h4><?php echo $value->the_title; ?></h4>

												<div class="review">
													<?php 
														if( have_rows('avaliacao',$value->ID) ) {

															$avaliacoes = get_field('avaliacao',$value->ID);
															foreach($avaliacoes as $avaliacao){ 
																$nota[] = $avaliacao['nota'];
															}

															$qtd_estrela = array_sum($nota) / count(array_filter($nota)); 

															for($i=1; $i <= 5; $i++){
																if($i <= $qtd_estrela){ ?>

																	<i class="fa fa-star" aria-hidden="true"></i>

																<?php }else{ ?>

																	<i class="fa fa-star off" aria-hidden="true"></i>

																<?php }
															}

														}else{

															for($i=1; $i <= 5; $i++){ ?>

																<i class="fa fa-star off" aria-hidden="true"></i>

															<?php }
														}
													?>

													<span>
														<?php 
															if( have_rows('avaliacao',$value->ID) ) {

																if(count($avaliacoes) == 1){
																	echo '1 avaliação';
																}else{
																	echo count($avaliacoes).' avaliações';
																}

															}else{

																echo '0 avaliações';
																
															}
														?>				
													</span>
												</div>

											</div>	
										</a>
									</div>
								<?php } ?>

							</div>
								
						<?php }

						if($blog){ ?>		

							<h2 class="sub-titulo">Notícias</h2>

							<div class="row produto list-produto">

								<?php foreach ($blog as $key => $value) { ?>
									<div class="col-6 result-busca noticias">
										<div class="border">
											<h4><?php echo $value->post_title; ?></h4>
											<a href="<?php the_permalink($value->ID); ?>" title="Saiba Mais" class="mais-item">
												<i class="fa fa-caret-right" aria-hidden="true"></i> Saiba Mais
											</a>
										</div>
									</div>
								<?php } ?>

							</div>
								
						<?php }

						if($representantes){ ?>

							<h2 class="sub-titulo">Representantes</h2>

							<div class="row representantes">

								<ul class="list-representantes">
									<?php foreach ($representantes as $key => $value) { ?>
										<li class="col-6 result-busca representantes">
											<div class="border">

												<h4><?php echo $value->post_title; ?></h4>
												<div class="content-txt">
													<?php if(get_field('e-mail_representantes',$value->ID) != ''){ ?>
														<span><strong>E-mail</strong> <?php the_field('e-mail_representantes',$value->ID); ?></span>
													<?php } ?>

													<?php if(get_field('telefone_representantes',$value->ID) != ''){ ?>
														<span><strong>Telefone</strong> <?php the_field('telefone_representantes',$value->ID); ?></span>
													<?php } ?>

													<?php if(get_field('celular_representantes',$value->ID) != ''){ ?>
														<span><strong>Celular</strong> <?php the_field('celular_representantes',$value->ID); ?></span>
													<?php } ?>

													<?php if(get_field('whatsapp_representantes',$value->ID) != ''){ ?>
														<span><strong>Whatsapp</strong> <?php the_field('whatsapp_representantes',$value->ID); ?></span>
													<?php } ?>

													<?php if(get_field('skype_representantes',$value->ID) != ''){ ?>
														<span><strong>Skype</strong> <?php the_field('skype_representantes',$value->ID); ?></span>
													<?php } ?>
												</div>
											</div>
										</li>

									<?php } ?>
								</ul>

							</div>
							
						<?php }

						if($page){ ?>
							<h2 class="sub-titulo">Institucional</h2>

							<div class="row">

								<?php foreach ($page as $key => $value) { ?>
									<div class="col-6 result-busca page">
										<div class="border">
											<?php 
												$imagem = wp_get_attachment_image_src( get_post_thumbnail_id($value->ID), 'medium' ); 
												if($imagem[0]){ ?>
													<img src="<?php echo $imagem[0]; ?>" alt="<?php echo $value->post_title; ?>" class="img-sidebar">
												<?php }
											?>
											<h4><?php echo $value->post_title; ?></h4>
											<p><?php echo $value->post_excerpt; ?></p>
											<a href="<?php the_permalink($value->ID); ?>" title="Saiba Mais" class="mais-item">
												<i class="fa fa-caret-right" aria-hidden="true"></i> Saiba Mais
											</a>
										</div>
									</div>
								<?php } ?>

							</div>

						<?php }
					}else{ ?>

						<section class="box-content">
							<div class="container">

								<p class="center">Desculpe, não conseguimos encontrar nenhum resultado com essas palavras.</p>

							</div>
						</section>
					<?php }
				?>


			</div>

			<div class="col-4 sidebar">

				<?php include 'sidebar-empresa.php'; ?>
				<?php include 'sidebar-noticias.php'; ?>

			</div>
		</div>

	</div>
</section>

<?php get_footer(); ?>