<?php 
	session_start();

	if(isset($_SESSION['id'])){
		
		if($post->ID != $_SESSION['id']){
			$url = get_post_permalink($_SESSION['id']).'#novo-pedido';
			header('Location: '.$url);
		}else{

			if(isset($_POST['nome'])){

				if(get_field('tipo')){
					$nome = $_POST['razao_social'];
					$doc = $_POST['cnpj'];
					$tipo = true;
				}else{
					$nome = $_POST['nome'];
					$doc = $_POST['cpf'];
					$tipo = false;
				}

				$update_post = array(
					'ID' => $post->ID,
					'post_title' => $nome
				);
				wp_update_post( $update_post );

				update_field( 'cpf__cnpj', $doc, $post->ID );
				update_field( 'email', $_POST['email'], $post->ID );

				update_field( 'telefone', $_POST['telefone'], $post->ID );
				update_field( 'celular', $_POST['celular'], $post->ID );

				update_field( 'endereco', $_POST['endereco'], $post->ID );
				update_field( 'numero', $_POST['numero'], $post->ID );
				update_field( 'bairro', $_POST['bairro'], $post->ID );
				update_field( 'cidade', $_POST['cidade'], $post->ID );
				update_field( 'uf', $_POST['uf'], $post->ID );
				update_field( 'cep', $_POST['cep'], $post->ID );

				update_field( 'nome_fantasia', $_POST['nome_fantasia'], $post->ID );
				update_field( 'inscricao_estadual', $_POST['inscricao_estadual'], $post->ID );
				update_field( 'email_xml', $_POST['email_xml'], $post->ID);
				update_field( 'email_financeiro', $_POST['email_financeiro'], $post->ID );
				
				update_field( 'usuario', $usuario, $post->ID );
				update_field( 'senha', $_POST['senha'], $post->ID );

				$url = get_post_permalink($post->ID).'#meus-dados/atualizado';
				header('Location: '.$url);

			}

		}

	}else{

		$url = get_home_url().'/minha-area';
		header('Location: '.$url);

	}

	$produtoOK = false;
?>

<?php get_header(); ?>

<section class="box-content clientes">
	<div class="container">

		<div class="row">
			<div class="col-12">

				<h2>
					<a href="<?php echo get_home_url(); ?>/minha-area" title="PRODUTOS">
						ÁREA RESTRITA
					</a>
					<span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
						<?php the_title(); ?>
					</span>
					<span>
						<i class="fa fa-angle-right" aria-hidden="true"></i>
						<div id="page-area"></div>
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

			<div class="col-9">
				<div class="cont-tab-area" id="novo-pedido">

					<h3>Bem vindo, <strong><?php the_title(); ?></strong></h3>

					<div class="pesquisa" style="width: 100%; float: left; clear: both; margin-top: 24px;">
						<label class="" rel="table-categorias" style="line-height: 48px; float: left; text-align: right; display: none;">Categoria: </label>
						<select name="table-categoria" id="table-categoria" style="float: left; width: 200px; font-size: 14px; margin: 0 0 0 15px; margin-right: 0px; border: 1px solid #3f3f40; border-radius: 5px; line-height: 50px; height: 50px; height: 50px; padding: 0 10px; margin-right: 30px;">
							<option value="">Todas as categorias</option>
						</select>

						<label class="" rel="table-pesquisa" style="line-height: 48px; float: left; text-align: right; display: none;">Pesquisar: </label>
						<input type="text" class="" name="table-pesquisa" id="table-pesquisa" onkeyup="filtro_produtos()" placeholder="Digite um nome.." style="width: 200px; font-size: 14px; margin: 0 0 0 15px;">

						<button type="button" class="print"><i class="fa fa-print" aria-hidden="true"></i></button>

						<div class="display-prod">
							<i class="fa fa-bars active" aria-hidden="true"></i>
							<i class="fa fa-th grid" aria-hidden="true"></i>
						</div>

					</div>

					<div class="table-responsive" style="display: block; clear: both;">
						<table class="table" id="table-produtos">
							<tbody>

								<?php 
									$terms = wp_get_post_terms( $post->ID, $post->post_type.'_taxonomy' );
									$grupo = $terms[0]->term_id;
									query_posts(
										array(
											'post_type' => 'produtos',
											'posts_per_page' => -1
										)
									); 

									$qtd = 0;
									//$term_prods = array();
									while ( have_posts() ) : the_post(); 
										$qtd++;
										$class_term = '';
										$term_atual = '';

											if( have_rows('precos') ){

												while ( have_rows('precos') ) : the_row();
													if($grupo == get_sub_field('grupo_cliente')){
														$preco = get_sub_field('preco');
														$produtoOK = true;
														break;
													}
												endwhile;
											}

											if($produtoOK){ 
												//if($qtd==1){
													//var_dump($post);
													$term_atual = wp_get_post_terms( $post->ID,'produtos_taxonomy' );
													//echo '<br><br><br>';
													//print_r($term_atual);
													//echo '<br><br><br>';
													foreach ($term_atual as $key => $value) {
														//print_r($value);
														$term_prods[$value->term_id] = array($value->slug, $value->name);
														$class_term .= ' '.$value->slug; 
														//echo $value->slug;
														//echo '<br>';
													}
													//$term_prods[] = $term_atual[0]->term_id;
													//print_r($term_prods);
													//echo '<br>'.$class_term;
												//}
												$imagem = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'thumbnail' ); ?>

												<tr class="<?php echo $class_term; ?>">
													<td width="30">
														<div class="input-checkbox center">
															<label>
																<input type="checkbox" name="<?php echo $post->ID; ?>" id="<?php echo $post->ID; ?>" item-nome="<?php the_title(); ?>" item-foto="" item-preco="<?php echo $preco; ?>" item-unidade="<?php the_field('unidade_medida'); ?>" value="<?php echo $post->ID; ?>">
															</label>
														</div>
													</td>
													<td width="80">
														<label for="<?php echo $post->ID; ?>" class="img-prod-grid">
															<img src="<?php echo $imagem[0]; ?>" alt="<?php the_title(); ?>">
														</label>
													</td>
													<td>
														<label for="<?php echo $post->ID; ?>">
															<h4 class="nome"><?php the_title(); ?></h4></td>
														</label>
													</td>
													<td class="preco" width="120">
														<span class="txt-preco-ajust"><?php echo 'R$ '.formata_moeda($preco); ?></span>
														
														<span class="info-preco"><?php the_field('unidade_medida'); ?></span>

														<?php /* if( have_rows('precos') ){

															$preco = false;
															while ( have_rows('precos') ) : the_row();
																if($grupo == get_sub_field('grupo_cliente')){
																	echo 'R$ '.formata_moeda(get_sub_field('preco'));
																	$preco = true;
																	break;
																}
															endwhile;

															if(!$preco){
																echo '<span class="preco_off">Preço não<br>disponível</span>';
															}

														}else{
															echo '<span class="preco_off">Preço não<br>disponível</span>';
														} */?>
													</td>
													<td class="qtd" width="135">
														<h4 class="qtd">QTD:</h4>
														<input type="text" name="qtd<?php echo $post->ID; ?>" placeholder="1" value="1">
													</td>
												</tr>
											<?php } ?>

									<?php endwhile;
									wp_reset_query(); ?>

							</tbody>
						</table>
					</div>

					<?php if($produtoOK){ ?>

					<?php }else{ ?>

						<p>Nenhum produto encontrado.</p>

					<?php } ?>

				</div>
				<div class="cont-tab-area" id="meus-pedidos">
					meus pedidos
				</div>
				<div class="cont-tab-area" id="meus-dados">
					<?php
						while ( have_posts() ) : the_post(); ?>
							
							<form action="<?php the_permalink(); ?>/#meus-dados" class="cadastro <?php if(get_field('tipo')){ echo 'pj'; }else{ echo 'pf'; } ?>" method="post">
								<div class="row">

									<label class="col-12 titulo">Dados Principais:</label>
									<fieldset class="col-12">
										<input type="text" class="inputPessoa pf" name="nome" id="nome" placeholder="Nome*" value="<?php echo get_the_title(); ?>">
										<input type="text" class="inputPessoa pj" name="razao_social" id="razao_social" placeholder="Razão Social*" value="<?php echo get_the_title(); ?>">
									</fieldset>

									<fieldset class="col-12">
										<input type="text" class="inputPessoa pj" name="nome_fantasia" id="nome_fantasia" placeholder="Nome Fantasia" value="<?php the_field('nome_fantasia'); ?>">
									</fieldset>

									<fieldset class="col-6">
										<input type="text" class="inputPessoa mask-cpf pf" name="cpf" id="cpf" placeholder="CPF*" value="<?php the_field('cpf__cnpj'); ?>">
										<input type="text" class="inputPessoa mask-cnpj pj" name="cnpj" id="cpnj" placeholder="CNPJ*" value="<?php the_field('cpf__cnpj'); ?>">
									</fieldset>

									<fieldset class="col-6">
										<input type="text" class="inputPessoa pj" name="inscricao_estadual" id="inscricao_estadual" placeholder="Inscrição Estadual*" value="<?php the_field('inscricao_estadual'); ?>">
									</fieldset>


									<label class="col-12 titulo">Informações de Contato:</label>
									<fieldset class="col-6">
										<input type="text" class="mask-telefone" name="telefone" id="telefone" placeholder="Telefone" value="<?php the_field('telefone'); ?>">
									</fieldset>

									<fieldset class="col-6">
										<input type="text" class="mask-telefone" name="celular" id="celular" placeholder="Celular" value="<?php the_field('celular'); ?>">
									</fieldset>

									<fieldset class="col-12">
										<input type="text" name="email" id="email" placeholder="E-mail*" value="<?php the_field('email'); ?>">
									</fieldset>

									<fieldset class="col-6">
										<input type="text" class="inputPessoa pj" name="email_xml" id="email_xml" placeholder="E-mail XML" value="<?php the_field('email_xml'); ?>">
									</fieldset>

									<fieldset class="col-6">
										<input type="text" class="inputPessoa pj" name="email_financeiro" id="email_financeiro" placeholder="E-mail Financeiro" value="<?php the_field('email_financeiro'); ?>">
									</fieldset>


									<label class="col-12 titulo">Endereço:</label>
									<fieldset class="col-7">
										<input type="text" name="endereco" id="endereco" placeholder="Endereço*" value="<?php the_field('endereco'); ?>">
									</fieldset>

									<fieldset class="col-2">
										<input type="text" name="numero" id="numero" placeholder="N.º*" value="<?php the_field('numero'); ?>">
									</fieldset>

									<fieldset class="col-3">
										<input type="text" name="cep" id="cep" class="mask-cep" placeholder="CEP*" value="<?php the_field('cep'); ?>">
									</fieldset>

									<fieldset class="col-5">
										<input type="text" name="bairro" id="bairro" placeholder="Bairro*" value="<?php the_field('bairro'); ?>">
									</fieldset>

									<fieldset class="col-5">
										<input type="text" name="cidade" id="cidade" placeholder="Cidade*" value="<?php the_field('cidade'); ?>">
									</fieldset>

									<fieldset class="col-2">
										<input type="text" name="uf" id="uf" placeholder="UF*" value="<?php the_field('uf'); ?>">
									</fieldset>
									

									<label class="col-12 titulo">Senha de acesso:</label>
									
									<fieldset class="col-12">
										<input type="password" name="senha" id="senha" placeholder="Senha*" value="<?php the_field('senha'); ?>">
									</fieldset>

									<fieldset class="col-12">
										<button type="submit" class="btn enviar">Alterar</button>
										<!--<a href="javascript:" class="btn enviar">Cadastrar</a>-->
									</fieldset>

									<fieldset class="col-12">
										<p class="msg-form"></p>
									</fieldset>

								</div>
							</form>

						<?php endwhile;
						wp_reset_query();
					?>
				</div>
			</div>

			<div class="col-3 sidebar">
				<ul class="list-menu">

					<li class="" id="menu-novo-pedido">
						<a href="<?php echo get_post_permalink($post->ID); ?>/#novo-pedido" title="Novo Pedido">
							<i class="fa fa-caret-right" aria-hidden="true"></i> Novo Pedido
						</a>
					</li>

					<li class="" id="menu-meus-pedidos" style="display: none;">
						<a href="<?php echo get_post_permalink($post->ID); ?>/#meus-pedidos" title="Meus Pedidos">
							<i class="fa fa-caret-right" aria-hidden="true"></i> Meus Pedidos
						</a>
					</li>

					<li class="" id="menu-meus-dados">
						<a href="<?php echo get_post_permalink($post->ID); ?>/#meus-dados" title="Meus Dados">
							<i class="fa fa-caret-right" aria-hidden="true"></i> Meus Dados
						</a>
					</li>

				</ul>

				<div class="btn-pedido-float">
					<?php if($produtoOK){ ?>

						<p class="msg-pedido"></p>
						<a href="javascript:" title="Solicitar Orçamento" id="confirmar-pedido" class="btn pedido">
							<i class="fa fa-shopping-cart" aria-hidden="true"></i> Confirmar Pedido
						</a>

					<?php } ?>
				</div>
			</div>
		</div>

	</div>
</section>

<div class="bg-modal" id="modal-pedido">
	<div class="box-modal">
		<div class="modal-conteudo">

			<i class="fa fa-times close-modal" aria-hidden="true"></i>
			<h2>Novo Pedido</h2>
			<p class="msg center"></p>

			<div class="content-modal"></div>

			<a href="javascript:" title="Solicitar Orçamento" id="enviar-pedido" class="btn orcamento">
				<i class="fa fa-shopping-cart" aria-hidden="true"></i> Enviar Pedido
			</a>
		</div>
	</div>
</div>

<?php //var_dump($term_prods); $term_prods = array_unique($term_prods); echo '<br><br>'; ?>
<?php //var_dump($term_prods); ?>

<?php get_footer(); ?>

<script type="text/javascript">

	jQuery(document).ready(function(){
		jQuery('.btn-pedido-float').width(jQuery('.sidebar').width());
		scroll_btn_pedido = jQuery(window).scrollTop();
		if(scroll_btn_pedido > 278){
			jQuery('.btn-pedido-float').addClass('top-fixed');
		}else{
			jQuery('.btn-pedido-float').removeClass('top-fixed');
		}
	});	

	jQuery(window).resize(function(){
		jQuery('.btn-pedido-float').width(jQuery('.sidebar').width());
	});	


	jQuery(window).scroll(function(){
		scroll_btn_pedido = jQuery(window).scrollTop();
		jQuery('.btn-pedido-float').attr('value',scroll_btn_pedido);
		if(scroll_btn_pedido > 278){
			jQuery('.btn-pedido-float').addClass('top-fixed');
		}else{
			jQuery('.btn-pedido-float').removeClass('top-fixed');
		}
	});

function filtro_produtos() {
	filter_categoria = jQuery('#table-categoria').val();
	filter_busca = jQuery('#table-pesquisa').val().toUpperCase();
	//alert(filter_busca);

				if((filter_categoria != '') && (filter_busca != '')){
					//alert(filter_categoria+' / '+filter_busca);

					jQuery('#table-produtos tr').each(function(){
						nome_produto = jQuery('.nome',this).html().toUpperCase();
						//alert(nome_produto);

						if(jQuery(this).hasClass(filter_categoria)){

							if(nome_produto.indexOf(filter_busca) > -1) {
								//alert('tem');
								jQuery(this).show();
							}else{
								//alert('não tem');
								jQuery(this).hide();
							}

						}else{
							jQuery(this).hide();
						}
					});

				}else{
					if(filter_categoria == ''){
						jQuery('#table-produtos tr').each(function(){
							nome_produto = jQuery('.nome',this).html().toUpperCase();

								if(nome_produto.indexOf(filter_busca) > -1) {
									//alert('tem');
									jQuery(this).show();
								}else{
									//alert('não tem');
									jQuery(this).hide();
								}
						});
					}else{
						jQuery('#table-produtos tr').each(function(){
							nome_produto = jQuery('.nome',this).html().toUpperCase();

							if(jQuery(this).hasClass(filter_categoria)){

								jQuery(this).show();

							}else{
								jQuery(this).hide();
							}
						});
					}
				}
}

	jQuery(document).ready(function(){

		<?php
		//var_dump($term_prods);
		//echo '<br><br>';

			if(count($term_prods) > 0){
				$select_categorias = '';
				//print_r($term_prods);
				//echo '<br><br>';
				//$term_prods = array_unique($term_prods); print_r($term_prods);

				foreach ($term_prods as $key => $value) { //var_dump($value);
					/*echo '<br>';
					echo 'slug = '.$value[0];
					echo '<br>';
					echo 'name = '.$value[1];*/
					$option_categorias .= '<br> <option value="'.$value[0].'">'.$value[1].'</option>';
				}

				echo "jQuery('#table-categoria').append('".$option_categorias."');";
			}
		?>

		jQuery('#table-categoria').change(function(){
			filtro_produtos();

			/*filter_categoria = jQuery(this).val();
			jQuery('#table-produtos tr').each(function(){
				if(jQuery(this).hasClass(filter_categoria)){

					jQuery(this).show();
					//myFunction();

				}else{
					jQuery(this).hide();
				}
			});*/
		});
	});

	function myFunction() { /*
		var input, filter, table, tr, td, i;

		filter_categoria = jQuery('#table-categoria').val();

		input = document.getElementById("table-pesquisa");
		filter = input.value.toUpperCase();
		table = document.getElementById("table-produtos");
		tr = table.getElementsByTagName("tr");
		for (i = 0; i < tr.length; i++) {
			td = tr[i].getElementsByTagName("td")[0];
			if (td) {
				if (td.innerHTML.toUpperCase().indexOf(filter) > -1) {
					tr[i].style.display = "";
				} else {
					tr[i].style.display = "none";
				}
			}       
		}*/
	}

	var produtos = [];
	var preco_total = 0;
	var preco_pedido = 0;

	jQuery('#confirmar-pedido').click(function() {

		produtos = [];
		preco_total = 0;
		preco_pedido = 0;

		jQuery('.msg-pedido').html('');
		qtd_item = 0;
		preco = 0;
		item = '<table id="confirmar-pedido">';
			item += '<thead>';
				item += '<tr>';
					item += '<th width="120" class="center">Qtd.</th>';
					item += '<th>Produto</th>';
					item += '<th width="50">Uni.</th>';
					item += '<th width="150">Preço</th>';
					item += '<th width="150">Total</th>';
				item += '</tr>';
			item += '</thead>';
			item += '<tbody>';

		jQuery('.input-checkbox input').each(function(){
			if(jQuery(this).is(':checked')){
				qtd_item = qtd_item+1;
				id = jQuery(this).val();
				nome = jQuery(this).attr('item-nome');
				preco = jQuery(this).attr('item-preco');
				item_unidade = jQuery(this).attr('item-unidade');

				qtd_produto = jQuery('input[name="qtd'+id+'"]').val();
				preco_total = parseFloat(qtd_produto)*parseFloat(preco);
				//alert('Preço total = '+preco_total+'  //  Preço atual do pedido = '+preco_pedido);
				preco_pedido = parseFloat(preco_pedido) + parseFloat(preco_total);
				//alert('Preço do pedido = '+preco_pedido);

				produtos.push({'id':id, 'nome':nome, 'preco':Number(preco).toFixed(2).replace('.', ','), 'qtd':qtd_produto, 'preco_total':Number(preco_total).toFixed(2).replace('.', ','), 'item_unidade':item_unidade});

				item += '<tr>';
					item += '<td class="center">'+qtd_produto+'</td>';
					item += '<td><strong>'+nome+'</strong></td>';
					item += '<td>'+item_unidade+'</td>';
					item += '<td>R$ '+Number(preco).toFixed(2).replace('.', ',')+'</td>';
					item += '<td><strong>R$ '+Number(preco_total).toFixed(2).replace('.', ',')+'<strong></td>';
				item += '</tr>';
			}
		});
			preco_pedido = Number(preco_pedido).toFixed(2).replace('.', ',');
			item += '</tbody>';
			item += '<tfoot>';
				item += '<tr>';
					item += '<th></th>';
					item += '<th colspan="3" class="right">TOTAL DO PEDIDO: </th>';
					item += '<th>R$ '+preco_pedido+'</th>';
				item += '</tr>';
			item += '</tfoot>';
		item += '</table>';

		if(qtd_item > 0){
			jQuery('#modal-pedido .content-modal').html(item);
			jQuery('#modal-pedido').css('display','table');
		}else{
			jQuery('.msg-pedido').html('Você precisa selecionar pelo menos um produto.');
		}
	});

	jQuery('#enviar-pedido').click(function(){
		nome_cliente = '<?php echo $post->post_title; ?>';
		cpf_cliente = '<?php echo get_field('cpf__cnpj'); ?>';
		email_cliente = '<?php echo get_field('email',$post->ID); ?>';
		telefone_cliente = '<?php echo get_field('telefone'); ?>';
		celular_cliente = '<?php echo get_field('celular'); ?>';
		endereco_cliente = '<?php echo get_field('endereco').', '.get_field('numero'); ?>';
		cep_cliente = '<?php echo get_field('cep'); ?>';
		bairro_cliente = '<?php echo get_field('bairro'); ?>';
		cidade_cliente = '<?php echo get_field('cidade').', '.get_field('uf'); ?>';

		para = '<?php the_field('email', 'option'); ?>';
		nome_site = '<?php the_field('titulo', 'option'); ?>';
		produtos = JSON.stringify(produtos);

		console.log(produtos);
		console.log(JSON.stringify(produtos));

		//url = '<?php echo get_home_url(); ?>/?produtos=' + produtos;
		//window.location.replace(url);

		jQuery.getJSON("<?php echo get_template_directory_uri(); ?>/pedido.php", { nome_cliente:nome_cliente, cpf_cliente:cpf_cliente, email_cliente:email_cliente, telefone_cliente:telefone_cliente, celular_cliente:celular_cliente, endereco_cliente:endereco_cliente, cep_cliente:cep_cliente, bairro_cliente:bairro_cliente, cidade_cliente:cidade_cliente, produtos:produtos, para:para, nome_site:nome_site, preco_pedido:preco_pedido }, function(result){		
			if(result=='ok'){
				jQuery('.msg-pedido').html('Pedido enviado com sucesso! Obrigado.');

				jQuery('.input-checkbox input').each(function(){
					if(jQuery(this).is(':checked')){
						jQuery(this).prop('checked', false);
					}
				});

			}else{
				jQuery('.msg-pedido').html('Desculpe, não foi possível enviar o seu pedido. Por favor, tente mais tarde.');
			}

			jQuery('#modal-pedido .content-modal').html('');
			jQuery('#modal-pedido').css('display','none');
		});


	});

	jQuery("form.cadastro").submit(function(event){
		jQuery('.enviar').html('Enviando').prop( "disabled", true );
		jQuery('.msg-form').removeClass('erro ok').html('');

		var nome = jQuery('#nome').val();
		var razao_social = jQuery('#razao_social').val();		
		var nome_fantasia = jQuery('#nome_fantasia').val();		
		var email = jQuery('#email').val();
		var telefone = jQuery('#telefone').val();
		var celular = jQuery('#celular').val();
		var cpf = jQuery('#cpf').val();
		var cnpj = jQuery('#cnpj').val();
		var endereco = jQuery('#endereco').val();
		var numero = jQuery('#numero').val();
		var bairro = jQuery('#bairro').val();
		var cidade = jQuery('#cidade').val();
		var cep = jQuery('#cep').val();
		var uf = jQuery('#uf').val();
		var senha = jQuery('#senha').val();
		var inscricao_estadual = jQuery('#inscricao_estadual').val();
		var email_xml = jQuery('#email_xml').val();
		var email_financeiro = jQuery('#email_financeiro').val();

		var para = '<?php the_field('email', 'option'); ?>';
		var nome_site = '<?php bloginfo('name'); ?>';

		var enviar = true;

		if((jQuery('.pessoa').val()) == '.pf'){
			if(nome == ''){
				jQuery('#nome').parent().addClass('erro');
				enviar = false;
			}

			if(cpf == ''){
				jQuery('#cpf').parent().addClass('erro');
				enviar = false;
			}
		}else{
			if(razao_social == ''){
				jQuery('#razao_social').parent().addClass('erro');
				enviar = false;
			}

			/*if(nome_fantasia == ''){
				jQuery('#nome_fantasia').parent().addClass('erro');
				enviar = false;
			}*/

			if(cnpj == ''){
				jQuery('#cnpj').parent().addClass('erro');
				enviar = false;
			}
		}

		if(email == ''){
			jQuery('#email').parent().addClass('erro');
			enviar = false;
		}

		/*if(telefone == ''){
			jQuery('#telefone').parent().addClass('erro');
			enviar = false;
		}

		if(celular == ''){
			jQuery('#celular').parent().addClass('erro');
			enviar = false;
		}*/

		if(endereco == ''){
			jQuery('#endereco').parent().addClass('erro');
			enviar = false;
		}

		if(numero == ''){
			jQuery('#numero').parent().addClass('erro');
			enviar = false;
		}

		if(bairro == ''){
			jQuery('#bairro').parent().addClass('erro');
			enviar = false;
		}

		if(cidade == ''){
			jQuery('#cidade').parent().addClass('erro');
			enviar = false;
		}

		if(uf == ''){
			jQuery('#uf').parent().addClass('erro');
			enviar = false;
		}

		if(cep == ''){
			jQuery('#cep').parent().addClass('erro');
			enviar = false;
		}

		if(senha == ''){
			jQuery('#senha').parent().addClass('erro');
			enviar = false;
		}

		if(!enviar){
			jQuery('.msg-form').html('Todos os campos são obrigatórios.');
			jQuery('.enviar').html('Alterar').prop( "disabled", false );
			return false;
		}else{
			//jQuery('form').submit();
			//jQuery('form').trigger("reset");
			jQuery('.enviar').html('Alterar').prop( "disabled", false );
		}
	});

	jQuery(document).ready(function(){
		jQuery('input.pessoa').click(function(){
			jQuery('.inputPessoa').hide();
			jQuery(jQuery(this).attr('value')).show();
		});
	});

	jQuery(document).ready(function(){
		jQuery('input').change(function(){
			if(jQuery(this).parent().hasClass('erro')){
				jQuery(this).parent().removeClass('erro');
			}
		});
	})

	jQuery(function(jQuery){
		url = jQuery(location).attr('hash');
		if(url == '#novo-pedido'){
			page = 'Novo Pedido';
			content = '#novo-pedido';
			menu = '#menu-novo-pedido';
		}

		if(url == '#meus-pedidos'){
			page = 'Meus Pedidos';
			content = '#meus-pedidos';
			menu = '#menu-meus-pedidos';
		}

		if((url == '#meus-dados/atualizado') || (url == '#meus-dados')){
			page = 'Meus Dados';
			content = '#meus-dados';
			menu = '#menu-meus-dados';
		}

		jQuery('.list-menu li').removeClass('active');
		jQuery('.cont-tab-area').removeClass('active');

		jQuery('#page-area').html(page);
		jQuery(content).addClass('active');
		jQuery(menu).addClass('active');

		/*if(jQuery('body').height() < jQuery(window).height()){
			jQuery('.footer').css({position: 'absolute', bottom: '0px'});
		}else{
			jQuery('.footer').css({position: 'relative'});
		}*/
	});
</script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/printThis.js"></script>
<script type="text/javascript">
	jQuery('.print').click(function(){
		jQuery("#table-produtos").printThis({
			importCSS: false,
			importStyle: false,
			loadCSS: ["<?php echo get_template_directory_uri(); ?>/assets/css/style.css","<?php echo get_template_directory_uri(); ?>/assets/css/style_print.css"],
			header: '<div class="h1"><img src="<?php the_field('logo_header', 'option'); ?>" width="300" align="center"></div><h3>Categoria: '+jQuery('#table-categoria option:selected').text()+'</h3>'
		});
	});
</script>

<script type="text/javascript" src="<?php echo get_template_directory_uri(); ?>/assets/js/maskedinput.js"></script>
<script type="text/javascript">
	jQuery(function(jQuery){
	   jQuery(".mask-telefone").mask("(99) 9999-9999?9");
	   jQuery(".mask-cpf").mask("999.999.999-99");
	   jQuery(".mask-cnpj").mask("99.999.999/9999-99");
	   jQuery(".mask-cep").mask("99999-999");
	});
</script>

<script type="text/javascript">
jQuery(document).ready(function(){
	jQuery('.display-prod i').click(function(){
		if(!jQuery(this).hasClass('active')){
			jQuery('.display-prod i').removeClass('active');
			jQuery(this).addClass('active');
			if(jQuery(this).hasClass('grid')){
				jQuery('#table-produtos').addClass('grid');
			}else{
				jQuery('#table-produtos').removeClass('grid');
			}
		}
	});
});


/*
	jQuery.noConflict();
	jQuery(document).ready(function(){
		/*jQuery('td', 'table').each(function(i) {
			jQuery(this).text(i+1);
		});*

jQuery('#table-produtos').each(function() {
    var currentPage = 0;
    var numPerPage = 10;
    var $table = jQuery(this);
    $table.bind('repaginate', function() {
        $table.find('tbody tr').hide().slice(currentPage * numPerPage, (currentPage + 1) * numPerPage).show();
    });
    $table.trigger('repaginate');
    var numRows = $table.find('tbody tr').length;
    var numPages = Math.ceil(numRows / numPerPage);
    var $pager = jQuery('<div class="pager"></div>');
    for (var page = 0; page < numPages; page++) {
        jQuery('<span class="page-number"></span>').text(page + 1).bind('click', {
            newPage: page
        }, function(event) {
            currentPage = event.data['newPage'];
            $table.trigger('repaginate');
            jQuery(this).addClass('active').siblings().removeClass('active');
        }).appendTo($pager).addClass('clickable');
    }
    $pager.insertBefore($table).find('span.page-number:first').addClass('active');
});
	});*/
</script>