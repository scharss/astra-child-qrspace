<?php
/**
 * Astra Child theme functions.
 */

/* Assets de la landing: SOLO en la portada. El CSS se imprime directamente
   en front-page.php despues de wp_head(); aqui solo el JS. */
function qrspace_landing_enqueue_assets() {
	if ( ! is_front_page() ) {
		return;
	}
	wp_enqueue_script( 'qrspace-landing', get_stylesheet_directory_uri() . '/js/script.js', array(), '1.0.0', true );
}
add_action( 'wp_enqueue_scripts', 'qrspace_landing_enqueue_assets', 20 );

/* Quitar estilos y scripts de Astra: SOLO en la portada. */
function qrspace_strip_astra_on_front() {
	if ( ! is_front_page() ) {
		return;
	}
	global $wp_styles, $wp_scripts;
	$astra_base = get_template_directory_uri() . '/'; // .../themes/astra/

	$remove = array( 'styles' => array(), 'scripts' => array() );
	if ( $wp_styles ) {
		foreach ( $wp_styles->registered as $handle => $style ) {
			if ( ! empty( $style->src ) && strpos( $style->src, $astra_base ) === 0 ) {
				$remove['styles'][] = $handle;
			}
		}
	}
	if ( $wp_scripts ) {
		foreach ( $wp_scripts->registered as $handle => $script ) {
			if ( ! empty( $script->src ) && strpos( $script->src, $astra_base ) === 0 ) {
				$remove['scripts'][] = $handle;
			}
		}
	}
	foreach ( $remove['styles'] as $h ) {
		wp_dequeue_style( $h );
		wp_deregister_style( $h );
	}
	foreach ( $remove['scripts'] as $h ) {
		wp_dequeue_script( $h );
		wp_deregister_script( $h );
	}
}
add_action( 'wp_enqueue_scripts', 'qrspace_strip_astra_on_front', 100 );
