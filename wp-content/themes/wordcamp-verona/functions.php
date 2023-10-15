<?php
/**
 * Filters the default array of categories for block types and adds a new block category.
 *
 * @param array[] $block_categories Array of categories for block types.
 * @param WP_Block_Editor_Context $block_editor_context The current block editor context.
 *
 * @return array[]
 */
function wrcamp_new_blocks_category( $block_categories, $block_editor_context ) {

	$block_category = array(
		'title' => __( 'WordCamp', 'wrcamp-verona' ),
		'slug'  => 'wordcamp',
		'icon'  => '',
	);

	$category_slugs = array_column( $block_categories, 'slug' );

	if ( ! in_array( $block_category['slug'], $category_slugs, true ) ) {
		$block_categories = array_merge(
			array(
				array(
					'title' => $block_category['title'],
					'slug'  => $block_category['slug'],
					'icon'  => $block_category['icon'],
				),
			),
			$block_categories
		);
	}

	return $block_categories;
}

add_filter( 'block_categories_all', 'wrcamp_new_blocks_category', 10, 2 );

/**
 * Require variations.
 */
require get_stylesheet_directory() . '/inc/variations/index.php';

/**
 * Register a template for an existing post type.
 *
 * @return void
 */
function wrcamp_register_template() {
	$post_type_object = get_post_type_object( 'post' );
	if ( $post_type_object ) {
		$post_type_object->template = [
			[
				'core/paragraph',
				[
					"style"       => [
						"typography" =>
							[
								"fontStyle"  => "italic",
								"fontWeight" => "400"
							],
					],
					"fontSize"    => "small",
					'placeholder' => 'Add Stand First...',
				],
			],
			[
				'core/heading',
				[
					'style'           => [
						'typography' => [
							'lineHeight' => "0"
						]
					],
					'backgroundColor' => 'foreground',
					'textColor'       => 'background',
					'fontSize'        => 'medium',
					'fontFamily'      => 'punch-label',
					'placeholder'     => 'Add Sub Title...',
				]
			]
		];
	}
}

add_action( 'init', 'wrcamp_register_template' );

/**
 * Filters the allowed block types for all editor types.
 *
 * See https://developer.wordpress.org/block-editor/reference-guides/filters/block-filters/.
 *
 * @param bool|string[] $allowed_block_types Array of block type slugs, or boolean to enable/disable all.
 * @param WP_Block_Editor_Context $editor_context The current block editor context.
 *
 * @return bool|string[]
 */
function wrcamp_filter_allowed_block_types( $allowed_block_types, $editor_context ) {
	if ( ! empty( $editor_context->post ) ) {
		return array( 'core/paragraph', 'core/heading', 'core/file' );
	}

	return $allowed_block_types;
}

add_filter( 'allowed_block_types_all', 'wrcamp_filter_allowed_block_types', 10, 2 );