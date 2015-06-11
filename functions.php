<?php
// copy below this line

// Add WordPress settings metabox for default background image
add_action( 'genesis_theme_settings_metaboxes', 'mc_theme_settings_metaboxes', 10, 1 );
function mc_theme_settings_metaboxes( $pagehook ) {
    add_meta_box( 'mc-default-background-image', __( 'Backstretch Default Background Image' ), 'mc_default_background_image_metabox', $pagehook, 'main', 'high' );
}
    // Content for the default/fallback image metabox
function mc_default_background_image_metabox() {
	printf( '<label for="%s[%s]" /><br />', GENESIS_SETTINGS_FIELD, 'mc_default_image' );
	printf( '<input type="text" name="%1$s[%2$s]" id="%1$s[%1$s]" size="75" value="%3$s" />', GENESIS_SETTINGS_FIELD, 'mc_default_image', genesis_get_option( 'mc_default_image' ) );
}

// Enqueue Backstretch JS and prepare images for loading
add_action( 'wp_enqueue_scripts', 'mc_enqueue_scripts' );
function mc_enqueue_scripts() {
    if ( ! genesis_get_option( 'mc_default_image' ) && ! has_post_thumbnail() )
        return;
        wp_enqueue_script( 'mc-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0', true );
        wp_enqueue_script( 'mc-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'mc-backstretch' ), '1.0.0', true );
}

// Set the Backstretch image
add_action( 'genesis_after', 'mc_set_background_image' );
function mc_set_background_image() {
    $image = array( 'src' => has_post_thumbnail() ? genesis_get_image( array( 'format' => 'url' ) ) : genesis_get_option( 'mc_default_image' ) );
	wp_localize_script( 'mc-backstretch-set', 'BackStretchImg', $image );
}
