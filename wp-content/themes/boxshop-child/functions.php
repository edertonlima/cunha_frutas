<?php 
function boxshop_child_register_scripts() {
    $parent_style = 'boxshop-style';

    wp_enqueue_style( $parent_style, get_template_directory_uri() . '/style.css', array('boxshop-reset') );
    wp_enqueue_style( 'boxshop-child-style',
        get_stylesheet_directory_uri() . '/style.css',
        array( $parent_style )
    );
}
add_action( 'wp_enqueue_scripts', 'boxshop_child_register_scripts' );
?>