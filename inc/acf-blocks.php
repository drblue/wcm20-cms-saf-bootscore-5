<?php
/**
 * Custom Gutenberg Blocks via ACF Blocks
 */

function bootscore_register_acf_block_types() {
	// Bail if ACF Pro is not installed and active
	if (!function_exists('acf_register_block_type')) {
		return;
	}

	// Register 'Movie Quote' block
	acf_register_block_type([
		'name' => 'bs-movie-quote',
		'title' => __('Movie Quote', 'bootscore'),
		'description' => __('A custom movie quote block.', 'bootscore'),
		'render_template' => 'template-parts/blocks/bs-movie-quote/bs-movie-quote.php',
		'category' => 'formatting',
		'icon' => 'format-quote',
		'supports' => [
			'align' => true,
		],
		'keywords' => ['movie', 'quote', 'film'],
	]);
}
add_action('acf/init', 'bootscore_register_acf_block_types');
