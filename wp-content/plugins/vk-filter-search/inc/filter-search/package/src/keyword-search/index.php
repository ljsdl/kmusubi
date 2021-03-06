<?php

/**
 * Registers the `vk-filter-search/keyword-search` block.
 */
if( function_exists('register_block_type_from_metadata')) {

	function register_block_vkfs_keyword_search() {
		register_block_type_from_metadata(
			__DIR__,
			array(
				'style'           => 'vk-filter-search-style',
				'editor_style'    => 'vk-filter-search-editor',
				'editor_script'   => 'vk-filter-search-block',
				'attributes'      => array(
					'className'   => array(
						'type'    => 'string',
						'default' => '',
					),
				),
				'render_callback' => 'vkfs_keyword_search_render_callback',
			)
		);
	}
	add_action( 'init', 'register_block_vkfs_keyword_search', 9999 );
}

/**
 * Rendering Keyword Search Block
 *
 * @param array $attributes attributes.
 * @param html  $content content.
 */
function vkfs_keyword_search_render_callback( $attributes, $content ) {
	$attributes = wp_parse_args(
		$attributes,
		array(
			'className' => '',
		)
	);
	$label         = '';
	$placeholder   = '';
	$outer_columns = array();
	$class_name    = ! empty( $attributes['className'] ) ? $attributes['className'] : '';
	return VK_Filter_Search::get_keyword_form_html( $label, $placeholder, $outer_columns, $class_name );
}