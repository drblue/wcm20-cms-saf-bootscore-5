<?php
/**
 * Custom template tags for this theme
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Bootscore
 */


// Category Badge
if ( ! function_exists( 'bootscore_category_badge' ) ) :
	function bootscore_category_badge() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
            echo '<div class="category-badge mb-2">';
            $thelist = '';
			$i = 0;
            foreach( get_the_category() as $category ) {
		      if ( 0 < $i ) $thelist .= ' ';
						    $thelist .= '<a href="' . esc_url( get_category_link( $category->term_id ) ) . '" class="badge bg-secondary">' . $category->name.'</a>';
						    $i++;
            }
            echo $thelist;
            echo '</div>';
		}
	}
endif;
// Category Badge End

// Movie Genre Badge
if ( ! function_exists( 'bootscore_movie_genre_badge' ) ) :
	function bootscore_movie_genre_badge() {
		// get all movie genres for the current post
		$genres = get_the_terms(get_the_ID(), 'mbt_movie_genre');

		// bail if no movie genres exist for this post
		if (!$genres) {
			return;
		}

		echo '<div class="movie-genre-badges mb-2">';
		$badges = [];

		// loop over all genres and construct a HTML-link for each of them
		foreach ($genres as $genre) {
			// get URL to the archive page for $genre
			$genre_url = get_term_link($genre, 'mbt_movie_genre');

			// create anchor link
			$badge = sprintf(
				'<a href="%s" class="badge bg-secondary">%s</a>',
				$genre_url,
				$genre->name
			);

			// add anchor link to list of genre badges
			array_push($badges, $badge);
		}

		// output badges with a space between them
		echo implode(' ', $badges);

		echo '</div>';
	}
endif;
// Category Badge End

if (!function_exists('bootscore_movie_score_badge')) {
	function bootscore_movie_score_badge() {
		// bail if ACF is not installed/activated, as we won't have a movie score to show anyway 😝
		if (!function_exists('get_field')) {
			return;
		}

		$movie_score = get_field('movie_score', false, false);

		if (!empty($movie_score)) {
			printf('<div class="badge bg-success mb-2">%s</div>',
				sprintf(
					__('Rating: %s', 'bootscore'),
					str_repeat('🍿', $movie_score)
				)
			);
		}
	}
}

if (!function_exists('bootscore_movie_gallery')) {
	function bootscore_movie_gallery() {
		// bail if ACF is not installed/activated, as we won't have a movie gallery to show anyway 😝
		if (!function_exists('get_field')) {
			return;
		}

		$gallery = get_field('gallery');
		// dump($gallery);

		if (!$gallery) {
			return;
		}

		?>
			<div class="flexslider">
				<ul class="slides">
					<?php foreach ($gallery as $image): ?>
						<li>
							<img src="<?php echo $image['url']; ?>">
						</li>
					<?php endforeach; ?>
				</ul>
			</div>
		<?php
	}
}

if (!function_exists('bootscore_movie_info')) {
	function bootscore_movie_info() {
		// bail if ACF is not installed/activated, as we won't have a movie poster to show anyway 😝
		if (!function_exists('get_field')) {
			return;
		}

		if (have_rows('info')) {
			// yes we have at least one row of sub-fields to show!

			echo '<dl>';
			while (have_rows('info')) {
				the_row();

				$label = get_sub_field('label');
				$value = get_sub_field('value');

				/**
				 * <li>
				 *   <strong>Biopremiär:</strong>
				 *   7 november 2014
				 * </li>
				 * <li>
				 *   <strong>Språk:</strong>
				 *   Engelska
				 * </li>
				 */
				printf('<dt>%s</dt><dd>%s</dd>', $label, $value);
			}
			echo '</dl>';
		}
	}
}

if (!function_exists('bootscore_movie_poster')) {
	function bootscore_movie_poster() {
		// bail if ACF is not installed/activated, as we won't have a movie poster to show anyway 😝
		if (!function_exists('get_field')) {
			return;
		}

		$poster = get_field('poster');
		// dump($poster);
		if (!$poster) {
			return;
		}

		$img = wp_get_attachment_image_src($poster['ID'], 'medium_large');
		$img_srcset = wp_get_attachment_image_srcset($poster['ID'], 'medium_large');
		// dump($img);
		// dump($img_srcset);
		printf('<img src="%s" srcset="%s" class="w-50 ms-3 mb-3 float-end img-fluid">', $img[0], $img_srcset);
	}
}

if (!function_exists('bootscore_movie_preamble')) {
	function bootscore_movie_preamble() {
		// bail if ACF is not installed/activated, as we won't have a movie preamble to show anyway 😝
		if (!function_exists('get_field')) {
			return;
		}

		$preamble = get_field('preamble', false, true);

		if (!empty($preamble)) {
			printf('<div class="preamble">%s</div>', $preamble);
		}
	}
}

if (!function_exists('bootscore_movie_actors')) {
	function bootscore_movie_actors() {
		// bail if ACF is not installed/activated, as we won't have any movie actors to show anyway 😝
		if (!function_exists('get_field')) {
			return;
		}

		$actors = get_field('actors');
		// dump($actors);
		if (!empty($actors)) {
			?>
				<h2><?php _e('Actors', 'bootscore'); ?></h2>

				<ul class="movie-actors row row-cols-3 row-cols-md-4 row-cols-lg-6 g-4">

					<?php foreach ($actors as $actor): ?>
						<div class="col">
							<div class="card">
								<a href="<?php echo get_the_permalink($actor); ?>">
									<?php echo get_the_post_thumbnail($actor, 'thumbnail', ['class' => 'card-img-top img-fluid']); ?>
								</a>
								<div class="card-body">
									<h3 class="card-title h6">
										<a href="<?php echo get_the_permalink($actor); ?>">
											<?php echo get_the_title($actor); ?>
										</a>
									</h3>
								</div>
							</div>
						</div>
					<?php endforeach; ?>

				</ul>
			<?php
		}
	}
}

// Category
if ( ! function_exists( 'bootscore_category' ) ) :
	function bootscore_category() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			/* translators: used between list items, there is a space after the comma */
			$categories_list = get_the_category_list( esc_html__( ', ', 'bootscore' ) );
			if ( $categories_list ) {
				/* translators: 1: list of categories. */
				printf( '<span class="cat-links"></span>', $categories_list ); // WPCS: XSS OK.
			}
		}
	}
endif;
// Category End


// Date
if ( ! function_exists( 'bootscore_date' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time.
	 */
	function bootscore_date() {
		$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
		if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
			$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time> <span class="time-updated-separator">/</span> <time class="updated" datetime="%3$s">%4$s</time>';
		}

		$time_string = sprintf( $time_string,
			esc_attr( get_the_date( DATE_W3C ) ),
			esc_html( get_the_date() ),
			esc_attr( get_the_modified_date( DATE_W3C ) ),
			esc_html( get_the_modified_date() )
		);

		$posted_on = sprintf(
			/* translators: %s: post date. */
			'%s',
			'<span rel="bookmark">' . $time_string . '</span>'
		);

		echo '<span class="posted-on">' . $posted_on . '</span>'; // WPCS: XSS OK.

	}
endif;
// Date End


// Author
if ( ! function_exists( 'bootscore_author' ) ) :

	function bootscore_author() {
		$byline = sprintf(
			esc_html_x( 'by %s', 'post author', 'bootscore' ),
			'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
		);

		echo '<span class="byline"> ' . $byline . '</span>'; // WPCS: XSS OK.

	}
endif;
// Author End


// Comments
if ( ! function_exists( 'bootscore_comments' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function bootscore_comments() {


		if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo ' | <i class="far fa-comments"></i> <span class="comments-link">';
			comments_popup_link(
				sprintf(
					wp_kses(
						/* translators: %s: post title */
						__( 'Leave a Comment', 'bootscore' ),
						array(
							'span' => array(
								'class' => array(),
							),
						)
					),
					get_the_title()
				)
			);
			echo '</span>';
		}

	}
endif;
// Comments End


// Edit Link
if ( ! function_exists( 'bootscore_edit' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function bootscore_edit() {

		edit_post_link(
			sprintf(
				wp_kses(
					/* translators: %s: Name of current post. Only visible to screen readers */
					__( 'Edit', 'bootscore' ),
					array(
						'span' => array(
							'class' => array(),
						),
					)
				),
				get_the_title()
			),
			' | <span class="edit-link">',
			'</span>'
		);
	}
endif;
// Edit Link End


// Single Comments Count
if ( ! function_exists( 'bootscore_comment_count' ) ) :
	/**
	 * Prints HTML with the comment count for the current post.
	 */
	function bootscore_comment_count() {
		if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
			echo ' | <i class="far fa-comments"></i> <span class="comments-link">';

			/* translators: %s: Name of current post. Only visible to screen readers. */
			// comments_popup_link( sprintf( __( 'Leave a comment<span class="screen-reader-text"> on %s</span>', 'bootscore' ), get_the_title() ) );
			comments_popup_link( sprintf( __( 'Leave a comment', 'bootscore' ), get_the_title() ) );


			echo '</span>';
		}
	}
endif;
// Single Comments Count End


// Tags
if ( ! function_exists( 'bootscore_tags' ) ) :
	/**
	 * Prints HTML with meta information for the categories, tags and comments.
	 */
	function bootscore_tags() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {


			/* translators: used between list items, there is a space after the comma */
			$tags_list = get_the_tag_list( '', ' ' );
			if ( $tags_list ) {
				/* translators: 1: list of tags. */
				printf( '<div class="tags-links mt-2">' . esc_html__( 'Tagged %1$s', 'bootscore' ) . '</div>', $tags_list ); // WPCS: XSS OK.
			}
		}
	}
endif;


add_filter( "term_links-post_tag", 'add_tag_class');

function add_tag_class($links) {
    return str_replace('<a href="', '<a class="badge bg-secondary" href="', $links);
}
// Tags End


// Featured Image
if ( ! function_exists( 'bootscore_post_thumbnail' ) ) :
	/**
	 * Displays an optional post thumbnail.
	 *
	 * Wraps the post thumbnail in an anchor element on index views, or a div
	 * element when on single views.
	 */
	function bootscore_post_thumbnail() {
		if ( post_password_required() || is_attachment() || ! has_post_thumbnail() ) {
			return;
		}

		if ( is_singular() ) :
			?>

			<div class="post-thumbnail">
				<?php the_post_thumbnail('full', array('class' => 'rounded mb-3')); ?>
			</div><!-- .post-thumbnail -->

		<?php else : ?>

		<a class="post-thumbnail" href="<?php the_permalink(); ?>" aria-hidden="true" tabindex="-1">
			<?php
			the_post_thumbnail( 'post-thumbnail', array(
				'alt' => the_title_attribute( array(
					'echo' => false,
				) ),
			) );
			?>
		</a>

		<?php
		endif; // End is_singular().
	}
endif;
// Featured Image End


// Internet Explorer Warning Alert
if ( ! function_exists( 'bootscore_ie_alert' ) ) :
	/**
	 * Displays an alert if page is browsed by Internet Explorer
	 */
	function bootscore_ie_alert() {
            $ua = htmlentities($_SERVER['HTTP_USER_AGENT'], ENT_QUOTES, 'UTF-8');
            if (preg_match('~MSIE|Internet Explorer~i', $ua) || (strpos($ua, 'Trident/7.0') !== false && strpos($ua, 'rv:11.0') !== false)) {
                echo '
                    <div class="container pt-5">
                        <div class="alert alert-warning alert-dismissible fade show mt-4" role="alert">
                            <h1>' . esc_html__( 'Internet Explorer detected', 'bootscore' ) . '</h1>
                            <p class="lead">' . esc_html__( 'This website will offer limited functionality in this browser.', 'bootscore' ) . '</p>
                            <p class="lead">' . esc_html__( 'Please use a modern and secure web browser like', 'bootscore' ) . ' <a href="https://www.mozilla.org/firefox/" target="_blank">Mozilla Firefox</a>, <a href="https://www.google.com/chrome/" target="_blank">Google Chrome</a>, <a href="https://www.opera.com/" target="_blank">Opera</a> ' . esc_html__( 'or', 'bootscore' ) . ' <a href="https://www.microsoft.com/edge" target="_blank">Microsoft Edge</a> ' . esc_html__( 'to display this site correctly.', 'bootscore' ) . '</p>
                        </div>
                    </div>
               ';
            }

	}
endif;


