<?php
/**
 * The template part for displaying content
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

// Get appropriate style for page
// $category = get_queried_object();
// $rootParentId = end(get_ancestors($category->term_id, 'category'));
// $rootCategory = get_category($rootParentId);
$url = get_permalink();

// if ($rootCategory) {
//     $url = get_site_url() . '/' . $rootCategory->slug . '/' . basename(get_permalink());
// }

// /**
//  * Get category style from the root parent e.g. Kids, Teachers, Grown-ups
//  * As some of the individual categories do not have category style set.
//  */
// if(get_field('category_style', 'category'. '_' . $rootParentId)) {
//     $categoryStyle = get_field('category_style', 'category'. '_' . $rootParentId);
// }
?>
<div class="col-xs-6 col-sm-3 post-item">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<header class="entry-header">
			<?php if ( is_sticky() && is_home() && ! is_paged() ) : ?>
				<span class="sticky-post"><?php _e( 'Featured', 'twentysixteen' ); ?></span>
			<?php endif; ?>
		</header><!-- .entry-header -->

		<?php if(has_post_thumbnail()): ?>
			<a href="<?php echo esc_url( $url ) ?>">
			<?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(),"slick-image"); ?>
			<?php if ($GLOBALS['wp_query']->current_post <=3): ?>
				<img src="<?php echo $image[0];?>" alt="<?php echo get_the_title()?>"/>
			<?php else: ?>
            <img class="lozad" data-src="<?php echo $image[0];?>" alt="<?php echo get_the_title()?>"/>
			<?php endif; ?>
			</a>
		<?php else: ?>
			<img class="img-responsive" src="<?php echo get_bloginfo('template_directory') . '/images/Placeholder.png'; ?>" alt="Placeholder image"/>
		<?php endif; ?>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( $url ) ), '</a></h2>' ); ?>

		<?php getButton('kids', $url); ?>

		<div class="entry-content">
			<?php
				wp_link_pages( array(
					'before'      => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'twentysixteen' ) . '</span>',
					'after'       => '</div>',
					'link_before' => '<span>',
					'link_after'  => '</span>',
					'pagelink'    => '<span class="screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>%',
					'separator'   => '<span class="screen-reader-text">, </span>',
				) );
			?>
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
