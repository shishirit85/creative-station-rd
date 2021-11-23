<?php
/**
 * The template for displaying search results pages
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<section id="primary" class="content-area">
		<main id="main" class="site-main" role="main">
			<div class="row">

				<div class="col-xs-12">
					<h1 class="page-title">Search results for: <?php echo get_search_query(); ?></h1>
				</div>

				<?php if ( have_posts() ) : ?>
					<?php
					// Start the loop.
					while ( have_posts() ) : the_post();

						// Responsive column resets mobile
						if (($wp_query->current_post) % 4 === 0) {
							echo '<div class="clearfix hidden-xs-block"></div>';
						}

						// Responsive column reset anything above mobile
						if (($wp_query->current_post) % 2 === 0) {
							echo '<div class="clearfix visible-xs-block"></div>';
						}

						/**
						 * Run the loop for the search to output the results.
						 * If you want to overload this in a child theme then include a file
						 * called content-search.php and that will be used instead.
						 */
						get_template_part( 'template-parts/content', 'search' );

						// End the loop.
					endwhile;

				// If no content, include the "No posts found" template.
				else :
					get_template_part( 'template-parts/content', 'none' );

				endif;
				?>
			</div>
		</main><!-- .site-main -->
	</section><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
