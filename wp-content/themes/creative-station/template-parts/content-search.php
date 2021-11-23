<?php
/**
 * The template part for displaying results in search pages
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

<div class="col-xs-6 col-sm-3 post-item">
	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
		<a href="<?php echo esc_url(get_permalink()); ?>">
			<?php the_post_thumbnail('slick-image'); ?>
		</a>

		<?php the_title( sprintf( '<h2 class="entry-title"><a href="%s" rel="bookmark">', esc_url( get_permalink() ) ), '</a></h2>' ); ?>

		<!-- Button -->
		<?php
		$categories = get_the_category(get_the_ID());
        $rootParentId = end(get_ancestors($categories[0]->cat_ID, 'category'));

        if (!$rootParentId) {
            $rootParentId = $categories[0]->cat_ID;
        }

        if(get_field('category_style', 'category'. '_' . $rootParentId)) {
            $categoryStyle = get_field('category_style', 'category'. '_' . $rootParentId);
        }
		?>

		<?php getButton($categoryStyle); ?>

		<?php if ( 'post' === get_post_type() ) : ?>

		<?php else : ?>

		<?php endif; ?>
	</article><!-- #post-## -->
</div>