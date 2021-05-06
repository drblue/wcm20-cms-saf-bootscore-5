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
						<div class="container align-items-end justify-content-between d-flex h-100 pb-3">
							<?php the_title('<h1>', '</h1>'); ?>
							<div class="h4">
								<?php bootscore_movie_score_badge(); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
			</header>

			<div class="container pb-5">

				<div class="entry-content">

					<?php if (!has_post_thumbnail()): ?>
						<?php the_title('<h1>', '</h1>'); ?>
					<?php endif; ?>

					<?php if (!has_post_thumbnail()): ?>
						<!-- Movie Score -->
						<?php bootscore_movie_score_badge(); ?>
					<?php endif; ?>

					<!-- Movie Medium -->
					<?php if (function_exists('get_field') && $medium = get_field('medium')): ?>
						<div class="movie-medium badge bg-primary">
							<?php echo $medium['label']; ?>
						</div>
					<?php endif; ?>

					<!-- Movie Genres -->
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

					<!-- Movie Info -->
					<?php bootscore_movie_info(); ?>
					<!-- Movie Gallery -->

					<!-- Movie Gallery -->
					<?php bootscore_movie_gallery(); ?>
					<!-- Movie Gallery -->

					<?php bootscore_movie_actors(); ?>

					<!-- Movie Poster -->
					<?php bootscore_movie_poster(); ?>
					<!-- End Movie Poster -->

					<?php bootscore_movie_preamble(); ?>

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
