<?php
/*
* Single Movie Review template
*/

get_header();
?>

<div id="content" class="site-content <?php if (!has_post_thumbnail()): ?>py-5 mt-4<?php endif; ?>">
	<div id="primary" class="content-area">

		<!-- Hook to add something nice -->
		<?php bs_after_primary(); ?>

		<main id="main" class="site-main">

			<header class="entry-header">
				<?php the_post(); ?>

				<?php if (has_post_thumbnail()): ?>
					<!-- Featured Image-->
					<?php $thumb = wp_get_attachment_image_src(get_post_thumbnail_id($post->ID), 'full'); ?>

					<div class="height-75 bg-dark text-light align-items-end dflex mb-3" style="background-image: url('<?php echo $thumb['0']; ?>;'); background-position: center;">
						<div class="container align-items-end d-flex h-100 pb-3">
							<?php the_title('<h1>', '</h1>'); ?>
						</div>
					</div>
				<?php endif; ?>
			</header>

			<div class="container pb-5">

				<div class="entry-content">

					<?php if (!has_post_thumbnail()): ?>
						<?php the_title('<h1>', '</h1>'); ?>
					<?php endif; ?>

					<!-- Movie Score -->
					<?php
						$movie_score = get_post_meta(get_the_ID(), 'movie_score', true);
						if (!empty($movie_score)) {
							printf('<div class="badge bg-success mb-2">%s</div>',
								sprintf(
									__('Rating: %s', 'bootscore'),
									$movie_score
								)
							);
						}
					?>

					<?php bootscore_movie_genre_badge(); ?>

					<!-- Trailers -->
					<?php
						// get all trailers (if any)
						$trailers = get_post_meta(get_the_ID(), 'trailer', false);
						if (!empty($trailers)) {
							echo '<div class="movie-trailers mb-2">';
							foreach ($trailers as $trailer) {
								printf('<a href="%s" class="badge bg-warning me-1">Trailer</a>', $trailer);
							}
							echo '</div>';
						}
					?>

					<p class="entry-meta">
						<small class="text-muted">
							<?php
								 bootscore_date();
								 _e(' by ', 'bootscore'); the_author_posts_link();
								 bootscore_comment_count();
							?>
						</small>
					</p>

					<?php the_content(); ?>

				</div>

				<footer class="entry-footer clear-both">
					<nav aria-label="Page navigation example">
						<ul class="pagination justify-content-center">
							<li class="page-item">
								<?php previous_post_link('%link'); ?>
							</li>
							<li class="page-item">
								<?php next_post_link('%link'); ?>
							</li>
						</ul>
					</nav>
				</footer>

				<?php comments_template(); ?>

			</div><!-- container -->

		</main><!-- #main -->

	</div><!-- #primary -->
</div><!-- #content -->
<?php get_footer(); ?>
