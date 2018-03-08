
<?php get_header(); ?>

<?php

	query_posts(
		array(
			'post_type' => 'representantes',
			'posts_per_page' => -1
		)
	);
	while ( have_posts() ) : the_post();

		$representantes[] = array(
			'ID' => $post->ID,
			'nome' => $post->post_title,
			'estado' => get_field('estado_representantes',$post->ID),
			'uf' => strtolower(get_field('uf_representantes',$post->ID)),
			'cidade' => get_field('cidade_representantes',$post->ID),
			'email' => get_field('e-mail_representantes',$post->ID),
			'telefone' => get_field('telefone_representantes',$post->ID),
			'celular' => get_field('celular_representantes',$post->ID),
			'whatsapp' => get_field('whatsapp_representantes',$post->ID),
			'skype' => get_field('skype_representantes',$post->ID)
		);

	endwhile;
	wp_reset_query();
?>

	<section class="box-content representantes">
		<div class="container">

			<div class="row">
				<div class="col-12">
					<h2>
						<a href="<?php echo get_home_url(); ?>/empresa" title="EMPRESA">
							EMPRESA
						</a>
						<span>
							<i class="fa fa-angle-right" aria-hidden="true"></i>
							REPRESENTANTES
						</span>
					</h2>
				</div>

				<div class="col-8">
					<div class="content-txt">
						<p class="center">

						</p>

						<h4 class="center">Selecione seu estado para encontrar o<br>representante mais próximo:</h4>
					</div>

					<?php /*
					<div class="col-6">
						<div class="select">
							<select name="estado" id="estado">
								<option value="Selecione um Estado">Selecione um Estado</option>
								
								<?php */
									foreach ($representantes as $key => $value) { 
										$estados[] = array(
											'uf' => $value['uf'],
											'nome' => $value['estado']
										);
									}

									/* 
									foreach (array_unique($estados) as $estado) { ?>
										<option value="<?php echo $estado; ?>"><?php echo $estado; ?></option>
									<?php }
								?>									

							</select>
						</div>
					</div>	

					<div class="col-6">
						<div class="select">
							<select name="cidade" id="cidade" disabled>
								<option value="">Selecione uma Cidade</option>
							</select>
						</div>
					</div>
					*/ ?>

					<ul id="map">

						<?php //print_r($representantes);
							foreach ($representantes as $key => $value) { ?>
								<li class="<?php echo $value['uf']; ?>" estado="<?php echo $value['uf']; ?>">
									<a href="javascript:" rel="<?php echo $value['uf']; ?>" id="<?php echo $value['uf']; ?>" title="<?php echo strtoupper($value['uf']); ?>">
										<img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="<?php echo strtoupper($value['uf']); ?>" />
									</a>
								</li>

								

							<?php } //$estados[] = ($value['uf'],$value['estado']); 
						?>

						<!--<li class="rs" estado="rs"><a class="" id="rs" title="RS"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="RS" /></a></li>
						<li class="sc" estado="sc"><a class="" id="sc" title="SC"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="SC" /></a></li>
						<li class="pr" estado="pr"><a class="" id="pr" title="PR"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="PR" /></a></li>
						<li class="sp" estado="sp"><a class="" id="sp" title="SP"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="SP" /></a></li>
						<li class="ms" estado="ms"><a class="" id="ms" title="MS"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="MS" /></a></li>
						<li class="rj" estado="rj"><a class="" id="rj" title="RJ"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="RJ" /></a></li>
						<li class="es" estado="es"><a class="" id="es" title="ES"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="ES" /></a></li>
						<li class="mg" estado="mg"><a id="mg" title="MG"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="MG" /></a></li>
						<li class="go" estado="go"><a id="go" title="GO"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="GO" /></a></li>
						<li class="df" estado="df"><a id="df" title="DF"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="DF" /></a></li>
						<li class="ba" estado="ba"><a id="ba" title="BA"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="BA" /></a></li>
						<li class="mt" estado="mt"><a class="" id="mt" title="MT"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="MT" /></a></li>
						<li class="ro" estado="ro"><a id="ro" title="RO"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="RO" /></a></li>
						<li class="ac" estado="ac"><a id="ac" title="AC"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="AC" /></a></li>
						<li class="am" estado="am"><a id="am" title="AM"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="AM" /></a></li>
						<li class="rr" estado="rr"><a id="rr" title="RR"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="RR" /></a></li>
						<li class="pa" estado="pa"><a id="pa" title="PA"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="PA" /></a></li>
						<li class="ap" estado="ap"><a id="ap" title="AP"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="AP" /></a></li>
						<li class="ma" estado="ma"><a id="ma" title="MA"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="MA" /></a></li>
						<li class="to" estado="to"><a id="to" title="TO"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="TO" /></a></li>
						<li class="se" estado="se"><a id="se" title="SE"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="SE" /></a></li>
						<li class="al" estado="al"><a id="al" title="AL"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="AL" /></a></li>
						<li class="pe" estado="pe"><a id="pe" title="PE"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="PE" /></a></li>
						<li class="pb" estado="pb"><a id="pb" title="PB"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="PB" /></a></li>
						<li class="rn" estado="rn"><a id="rn" title="RN"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="RN" /></a></li>
						<li class="ce" estado="ce"><a id="ce" title="CE"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="CE" /></a></li>
						<li class="pi" estado="pi"><a id="pi" title="PI"><img src="<?php echo get_template_directory_uri(); ?>/assets/images/null.gif" alt="PI" /></a></li>-->
					</ul>

					<div class="col-12">
						<ul class="list-representantes"></ul>
					</div>
					
				</div>

				<div class="col-4 sidebar">

					<?php include 'sidebar-empresa.php'; ?>
					<?php include 'sidebar-noticias.php'; ?>

				</div>
			</div>

		</div>
	</section>

<?php get_footer(); ?>

<script type="text/javascript">
	<?php 
		echo 'var representantes = '. json_encode($representantes).';';
	?>

	jQuery('form.login').submit(function(event){

		jQuery('.enviar').html('Enviando').prop( "disabled", true );
		jQuery('.msg-form').removeClass('erro ok').html('');

		var usuario = jQuery('#usuario').val();
		var senha = jQuery('#senha').val();		

		var enviar = true;

		if(usuario == ''){
			jQuery('#usuario').parent().addClass('erro');
			enviar = false;
		}

		if(senha == ''){
			jQuery('#senha').parent().addClass('erro');
			enviar = false;
		}

		if(!enviar){
			jQuery('.msg-form').html('Todos os campos são obrigatórios.');
			jQuery('.enviar').html('Entrar').prop( "disabled", false );
			return false;
		}else{
			jQuery('.enviar').html('Enviar').prop( "disabled", false );
			//event.preventDefault();
		}		
		
	});

	/*jQuery(".enviar").click(function(){

	});*/

	jQuery(document).ready(function(){

		jQuery("#estado").change(function(){
			var cidade = '<option value="Selecione uma Cidade">Selecione uma Cidade</option>';
			val_estado = jQuery('#estado option:selected').val();
			var cidades = [];

			if(val_estado != 'Selecione um Estado'){

				jQuery.each(representantes, function (key, val) {
					if(val.estado == val_estado) {
						cidades.push(val.cidade);
					}
				});
				cidades = cidades.filter(function(elem, pos, self) {
					return self.indexOf(elem) == pos;
				});

				jQuery.each(cidades, function (key, val) {
					cidade += '<option value="' + val + '">' + val + '</option>';
				});

				jQuery("#cidade").html(cidade).prop('disabled', false);
			}else{
				jQuery('#cidade').html(cidade).prop('disabled', true);
			}
		}).change();

		jQuery("#cidade").change(function(){
			val_cidade = jQuery('#cidade option:selected').val();
			val_estado = jQuery('#estado option:selected').val();
			list_representantes = '';

			if(val_cidade != 'Selecione uma Cidade'){
				jQuery.each(representantes, function (key, val) { //alert(val.cidade);
					if((val.estado == val_estado) && (val.cidade == val_cidade)) { //alert(val.estado+' = '+val_estado);

						list_representantes += '<li>';
						list_representantes += '<h3>'+val.nome+'</h3><div class="content-txt">';

						if(val.email != ''){
							list_representantes += '<span><strong>E-mail</strong>'+val.email+'</span>'
						}

						if(val.telefone != ''){
							list_representantes += '<span><strong>Telefone</strong>'+val.telefone+'</span>'
						}

						if(val.celular != ''){
							list_representantes += '<span><strong>Celular</strong>'+val.celular+'</span>'
						}

						if(val.whatsapp != ''){
							list_representantes += '<span><strong>Whatsapp</strong>'+val.whatsapp+'</span>'
						}

						if(val.skype != ''){
							list_representantes += '<span><strong>Skype</strong>'+val.skype+'</span>'
						}

						list_representantes += '</div></li>';
					}
				});
			}

			jQuery('.list-representantes').append(list_representantes);
		}).change();

		jQuery("#map li a").click(function(){
			//val_cidade = jQuery('#cidade option:selected').val();
			val_estado = jQuery(this).attr('rel');
			list_representantes = '';

			if(val_estado != ''){
				jQuery('.list-representantes').html('');
				jQuery("#map li a").removeClass('active');
				jQuery(this).addClass('active');

				jQuery.each(representantes, function (key, val) { //alert(val.cidade);
					if(val.uf == val_estado) { //alert(val.uf+' = '+val_estado);

						list_representantes += '<li>';
						list_representantes += '<h3>'+val.nome+'</h3><div class="content-txt">';

						if(val.email != ''){
							list_representantes += '<span><strong>E-mail</strong>'+val.email+'</span>'
						}

						if(val.telefone != ''){
							list_representantes += '<span><strong>Telefone</strong>'+val.telefone+'</span>'
						}

						if(val.celular != ''){
							list_representantes += '<span><strong>Celular</strong>'+val.celular+'</span>'
						}

						if(val.whatsapp != ''){
							list_representantes += '<span><strong>Whatsapp</strong>'+val.whatsapp+'</span>'
						}

						if(val.cidade != ''){
							list_representantes += '<span><strong>Cidade</strong>'+val.cidade+', '+val.estado+'</span>'
						}

						if(val.skype != ''){
							list_representantes += '<span><strong>Skype</strong>'+val.skype+'</span>'
						}

						list_representantes += '</div></li>';
					}
				});
			}

			jQuery('.list-representantes').append(list_representantes);
		});

		jQuery('input').change(function(){
			if(jQuery(this).parent().hasClass('erro')){
				jQuery(this).parent().removeClass('erro');
			}
		});

	})
</script>

<script type="text/javascript">
	jQuery(document).ready(function(){
		jQuery('.nav ul li.menu-empresa').addClass('active');
	});
</script>