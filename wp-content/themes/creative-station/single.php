<?php
/**
 * The template for displaying all single posts and attachments
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

$category = null;
$categoryName = explode('/', get_query_var('category_name'));

if (!empty($categoryName)) {
    $category = get_category_by_slug($categoryName[0]);
    $categoryStyle = get_field('category_style', 'category'. '_' . $category->cat_ID);
}

if (!$category) {
    $category = getTopLevelCategory();

    if ($category) {
        if(get_field('category_style', 'category'. '_' . $category->cat_ID)) {
            $categoryStyle = get_field('category_style', 'category'. '_' . $category->cat_ID);
        }
    }
}

get_header(); ?>

<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the single post content template.
			get_template_part( 'template-parts/content', 'single' );

			if ( is_singular( 'attachment' ) ) {
				// Parent post navigation.
				the_post_navigation( array(
					'prev_text' => _x( '<span class="meta-nav">Published in</span><span class="post-title">%title</span>', 'Parent post link', 'twentysixteen' ),
				) );
			} elseif ( is_singular( 'post' ) ) {
				$post_id = $post->ID;
				$rootParentId = $category->cat_ID;

				// Get post navigation using root category id.
				getCustomPostNavigation($post_id, $rootParentId, $category);
			}

			// End of the loop.
		endwhile;
		?>

		<!-- Handpicked related ideas -->
		
	</main><!-- .site-main -->

</div><!-- .content-area -->

<?php //get_sidebar(); ?>
<?php get_footer(); ?>
