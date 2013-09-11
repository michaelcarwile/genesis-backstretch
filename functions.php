//* Load backstretch js

/** Add metabox for backstretch default/fallback background image */
add_action( 'genesis_theme_settings_metaboxes', 'themename_theme_settings_metaboxes', 10, 1 );
function themename_theme_settings_metaboxes( $pagehook ) {

  add_meta_box( 'themename-default-background-image', __( 'Background - Default Image', 'themename' ), 'themename_default_background_image_metabox', $pagehook, 'main', 'high' );

}

/** Content for the default/fallback image metabox */
function themename_default_background_image_metabox() {

	printf( '<label for="%s[%s]" /><br />', GENESIS_SETTINGS_FIELD, 'themename_default_image' );
	printf( '<input type="text" name="%1$s[%2$s]" id="%1$s[%1$s]" size="75" value="%3$s" />', GENESIS_SETTINGS_FIELD, 'themename_default_image', genesis_get_option( 'themename_default_image' ) );

}

/** Load Backstretch script and prepare images for loading */
add_action( 'wp_enqueue_scripts', 'themename_enqueue_scripts' );
function themename_enqueue_scripts() {

if ( ! genesis_get_option( 'themename_default_image' ) && ! has_post_thumbnail() )
		return;

	wp_enqueue_script( 'themename-backstretch', get_bloginfo( 'stylesheet_directory' ) . '/js/backstretch.js', array( 'jquery' ), '1.0.0', true );
	wp_enqueue_script( 'themename-backstretch-set', get_bloginfo('stylesheet_directory').'/js/backstretch-set.js' , array( 'jquery', 'themename-backstretch' ), '1.0.0', true );

}

add_action( 'genesis_after', 'themename_set_background_image' );
function themename_set_background_image() {

	$image = array( 'src' => has_post_thumbnail() ? genesis_get_image( array( 'format' => 'url' ) ) : genesis_get_option( 'themename_default_image' ) );

	wp_localize_script( 'themename-backstretch-set', 'BackStretchImg', $image );

}
