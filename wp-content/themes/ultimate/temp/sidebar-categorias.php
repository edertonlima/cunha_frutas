<h2>CATEGORIAS</h2>
<ul class="list-menu">

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
					<i class="fa fa-caret-right" aria-hidden="true"></i> <?php echo $categoria->name; ?>
				</a>
			</li>

			<?php
		}
	?>

</ul>