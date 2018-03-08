<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive.
 *
 * Override this template by copying it to yourtheme/woocommerce/archive-product.php
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     2.0.0
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

global $boxshop_theme_options;

get_header();

$extra_class = "";
$page_column_class = boxshop_page_layout_columns_class($boxshop_theme_options['ts_prod_cat_layout']);

$show_breadcrumb = get_post_meta(wc_get_page_id( 'shop' ), 'ts_show_breadcrumb', true);
$show_page_title = apply_filters( 'woocommerce_show_page_title', true ) && get_post_meta(wc_get_page_id( 'shop' ), 'ts_show_page_title', true);
if($show_breadcrumb && isset($boxshop_theme_options['ts_breadcrumb_layout']) ){
	$extra_class = 'show_breadcrumb_'.$boxshop_theme_options['ts_breadcrumb_layout'];
}
boxshop_breadcrumbs_title($show_breadcrumb, $show_page_title, woocommerce_page_title(false));

$show_top_content_widget_area = is_active_sidebar('product-category-top-content') && $boxshop_theme_options['ts_prod_cat_top_content'];
?>
<div class="page-container <?php echo esc_attr($extra_class) ?>">

	<!-- Left Sidebar -->
	<?php if( $page_column_class['left_sidebar'] ): ?>
		<aside id="left-sidebar" class="ts-sidebar <?php echo esc_attr($page_column_class['left_sidebar_class']); ?>">
		<?php if( is_active_sidebar($boxshop_theme_options['ts_prod_cat_left_sidebar']) ): ?>
			<?php dynamic_sidebar( $boxshop_theme_options['ts_prod_cat_left_sidebar'] ); ?>
		<?php endif; ?>
		</aside>
	<?php endif; ?>	
	
	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action( 'woocommerce_before_main_content' );
	?>
	<div id="main-content" class="<?php echo esc_attr($page_column_class['main_class']); ?>">	
		<div id="primary" class="site-content">
		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>
		
			<div class="before-loop-wrapper">
			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				do_action( 'woocommerce_before_shop_loop' );
			?>
			</div>
			
			<!-- Top Content -->
			<?php if( $show_top_content_widget_area ): ?>
				<aside class="ts-sidebar product-category-top-content" style="display: none">
					<?php dynamic_sidebar( 'product-category-top-content' ); ?>
				</aside>
			<?php endif; ?>
			
			<?php 
			global $woocommerce_loop;
			if( absint($boxshop_theme_options['ts_prod_cat_columns']) > 0 ){
				$woocommerce_loop['columns'] = absint($boxshop_theme_options['ts_prod_cat_columns']);
			}
			?>
			<div class="woocommerce columns-<?php echo esc_attr($woocommerce_loop['columns']); ?>">
			<?php woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories( array('before' => '<div class="list-categories">', 'after' => '</div>') ); $woocommerce_loop['loop'] = 0; ?>

				<?php while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content', 'product' ); ?>

				<?php endwhile; // end of the loop. ?>

			<?php woocommerce_product_loop_end(); ?>
			</div>
			
			<div class="after-loop-wrapper">
			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>
			</div>
			
		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action( 'woocommerce_after_main_content' );
	?>
		</div>
	</div>
	<!-- Right Sidebar -->
	<?php if( $page_column_class['right_sidebar'] ): ?>
		<aside id="right-sidebar" class="ts-sidebar <?php echo esc_attr($page_column_class['right_sidebar_class']); ?>">
		<?php if( is_active_sidebar($boxshop_theme_options['ts_prod_cat_right_sidebar']) ): ?>
			<?php dynamic_sidebar( $boxshop_theme_options['ts_prod_cat_right_sidebar'] ); ?>
		<?php endif; ?>
		</aside>
	<?php endif; ?>	
	
</div>
<?php get_footer( 'shop' ); ?>