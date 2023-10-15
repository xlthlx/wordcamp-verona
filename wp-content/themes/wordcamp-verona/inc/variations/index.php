<?php
/**
 * Enqueue blocks variations script.
 */
function wrcamp_enqueue_header_variation() {
	wp_enqueue_script( 'header-variations', get_stylesheet_directory_uri() . '/inc/variations/index.js', [
		'wp-blocks',
		'wp-dom',
		'wp-edit-post',
		'lodash',
	], wp_get_theme()->get( 'Version' ), true );
}

add_action( 'enqueue_block_editor_assets', 'wrcamp_enqueue_header_variation' );

/**
 * Filters list of allowed mime types and file extensions.
 *
 * @param array $mimes Mime types keyed by the file extension regex corresponding to those types.
 *
 * @return array
 */
function wrcamp_swf_custom_mime_type( array $mimes ): array {

	// Add swf extension.
	$mimes['swf'] = 'application/x-shockwave-flash';

	return $mimes;
}

add_filter( 'upload_mimes', 'wrcamp_swf_custom_mime_type' );

/**
 * Enqueue blocks variations script.
 */
function wrcamp_enqueue_swf_variation() {
	wp_enqueue_script( 'swf-variations', get_stylesheet_directory_uri() . '/inc/variations/swf.js', [
		'wp-blocks',
		'wp-dom-ready',
		'wp-edit-post',
	], wp_get_theme()->get( 'Version' ), false );
}

add_action( 'enqueue_block_editor_assets', 'wrcamp_enqueue_swf_variation' );

/**
 * Render the block variation.
 *
 * @param string $block_content The block content.
 * @param array $block The full block, including name and attributes.
 *
 * @return string
 */
function wrcamp_set_swf_player( $block_content, $block ) {
	if ( ! empty( $block_content ) && $block['blockName'] === 'core/file' ) {

		$dom = new DOMDocument();
		$dom->loadHTML( $block_content );

		$tag = $dom->getElementsByTagName( 'a' );
		$url = $tag[0]->getAttribute( 'href' );
		$id  = $tag[0]->getAttribute( 'id' );

		$file_types = array( '.swf' );

		if ( str_replace( $file_types, '', mb_strtolower( $url ) ) !== mb_strtolower( $url ) ) {
			return '<div class="wp-block-xlt-swf-player" id="' . $id . '"></div>
					<script>
					let player_id = "' . $id . '";
					let player_file = "' . $url . '";
					</script>
					<script type="text/javascript" src="' . get_stylesheet_directory_uri() . '/inc/variations/config.js" 
					id="ruffle-config"></script>
					';
		}

		return $block_content;
	}

	return $block_content;
}

add_filter( 'render_block', 'wrcamp_set_swf_player', 10, 2 );

/**
 * Enqueues Ruffle main script.
 *
 * @return void
 */
function wrcamp_enqueue_ruffle_script() {
	if ( is_singular() ) {
		$id = get_the_ID();
		if ( has_block( 'core/file', $id ) ) {
			//In a live site, it's better to use https://unpkg.com/@ruffle-rs/ruffle.
			wp_enqueue_script( 'ruffle', 'https://unpkg.com/@ruffle-rs/ruffle@0.1.0-nightly.2023.11.20/ruffle.js', [],
				wp_get_theme()->get( 'Version' ), true );
		}
	}
}

add_action( 'wp_enqueue_scripts', 'wrcamp_enqueue_ruffle_script' );