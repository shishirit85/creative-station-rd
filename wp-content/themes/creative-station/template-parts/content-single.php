<?php
/**
 * The template part for displaying single posts
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<div class="row">
    <div class="mage-error-messages">

    </div>

	<div class="col-xs-12 col-sm-12 col-md-8">
		<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<header class="entry-header">
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
			</header><!-- .entry-header -->

			<?php the_excerpt(); ?>

			<!-- Author and post date -->
			<?php if(get_field('show_date')): ?>
				<p class="post-date"></a><?php the_date('F j, Y'); ?></p>
			<?php endif; ?>

			<div class="post-featured-image">
                <?php the_post_thumbnail('medium_large', array('class' => 'img-responsive post-image', 'alt' => esc_html ( get_the_title() ), 'loading' => '')); ?>
			</div>

			<div class="row">
				<!-- <div class="col-xs-12 col-sm-6 social-share"> -->
					<!-- Social media links here -->
					<!-- <div id="twitter-tweet">
						<a class="twitter-share-button" href="https://twitter.com/intent/tweet">Tweet</a>
					</div>
					<div class="fb-share-button" data-href="https://developers.facebook.com/docs/plugins/" data-layout="button" data-size="small" data-mobile-iframe="true"><a class="fb-xfbml-parse-ignore" target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2Fdevelopers.facebook.com%2Fdocs%2Fplugins%2F&amp;src=sdkpreparse">Share</a></div>
					<a data-pin-do="buttonBookmark" data-pin-save="true" href="https://www.pinterest.com/pin/create/button/"></a>
					<a href="javascript:window.print()" class="print"></a>
				</div> -->
				
			</div>

			<div class="entry-content">
				<div class="top-craft-ideas hidden-sm hidden-md hidden-lg">
					<?php get_template_part('template-parts/mobile','shopping-list')?>
				</div>
				<!-- Project instructions -->
				<?php get_template_part( 'template-parts/project', 'instructions' ); ?>

			</div><!-- .entry-content -->

			<footer class="entry-footer">
				<?php
				edit_post_link(
					sprintf(
					/* translators: %s: Name of current post */
						__( 'Edit<span class="screen-reader-text"> "%s"</span>', 'twentysixteen' ),
						get_the_title()
					),
					'<span class="edit-link">',
					'</span>'
				);
				?>
			</footer><!-- .entry-footer -->
		</article><!-- #post-## -->
	</div>

	<div class="top-craft-ideas hidden-xs col-sm-12 col-md-4">
		<?php get_sidebar( 'single-right' ); ?>
	</div>
</div>