<?php

/**
 * Movie Quote Block Template
 *
 * @param array $block The block settings and attributes
 * @param string $content The block inner HTML (empty)
 * @param bool $is_preview True when previewed in Gutenberg editor
 * @param int|string $post_id The ID of the current post that this block is attached to
 */

/*
dump([
	'block' => $block,
	'content' => $content,
	'is_preview' => $is_preview,
	'post_id' => $post_id,
]);
*/

// Create id for wrapping element (while allowing for user to set their own anchor name)
$id = "bs-movie-quote-{$block['id']}";
if (!empty($block['anchor'])) {
	$id = $block['anchor'];
}

// Create class for wrapping element
$className = 'bs-movie-quote';
if (!empty($block['className'])) {
	$className .= " {$block['className']}";
}
if (!empty($block['align'])) {
	$className .= " align{$block['align']}";
}

$quote = get_field('quote') ?: "A funny movie quote";
$character = get_field('character') ?: "Movie Character name";
$image_id = get_field('image');
$background_color = get_field('background_color') ?: 'var(--bs-light)';  // "#db4871"
$text_color = get_field('text_color') ?: 'var(--bs-dark)';  // "#fff2f5"

// dump([
// 	'background_color' => $background_color,
// 	'text_color' => $text_color,
// ]);

?>

<figure id="<?php echo $id; ?>" class="<?php echo $className; ?>">
	<div class="bs-movie-quote-content">
		<blockquote class="bs-movie-quote-text">
			<?php echo $quote; ?>
		</blockquote>
		<figcaption>
			<cite class="bs-movie-quote-character"><?php echo $character; ?></cite>
		</figcaption>
		<button class="nice-button-orange">Read more</button>
	</div>

	<?php if ($image_id): ?>
		<div class="bs-movie-quote-image">
			<?php echo wp_get_attachment_image($image_id, 'medium', false, ['class' => 'img-fluid']); ?>
		</div>
	<?php endif; ?>

	<style type="text/css">
		#<?php echo $id; ?>,
		#<?php echo $id; ?> blockquote,
		#<?php echo $id; ?> figcaption {
			background-color: <?php echo $background_color; ?>;
			color: <?php echo $text_color; ?>;
		}
	</style>
</figure>

<?php
