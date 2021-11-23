<?php
/**
 * The template for displaying archive pages
 *
 * Used to display archive-type pages if nothing more specific matches a query.
 * For example, puts together date-based pages if no date.php file exists.
 *
 * If you'd like to further customize these archive views, you may create a
 * new template file for each one. For example, tag.php (Tag archives),
 * category.php (Category archives), author.php (Author archives), etc.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

// if(!is_tag()) {
//     $category = get_queried_object();
//     $rootParentId = end(get_ancestors($category->term_id, 'category'));

//     /**
//      * Get category style from the root parent e.g. Kids, Teachers, Grown-ups
//      * As some of the individual categories do not have category style set.
//      */
//     if(get_field('category_style', 'category'. '_' . $rootParentId)) {
//         $categoryStyle = get_field('category_style', 'category'. '_' . $rootParentId);
//     }
// }

get_header(); 
$parentCatList = get_category_parents(get_queried_object_id(),false,',');
$parentCatListArray = explode(",",$parentCatList);
if ($parentCatListArray[0] == "Adults" || $parentCatListArray[0]=="Educational" || $parentCatListArray[0]=="Seasons"){
	$topParentName=mb_strtolower($parentCatListArray[0]);
} else{
$topParentName = mb_strtolower($parentCatListArray[1]);
}
?>

<div class="archive-header">
	<?php echo '<img src="'. get_bloginfo('template_directory') . '/images/listing_banners/'. $topParentName. '.jpg" alt="" class="archive_image" loading="lazy">'; ?>
</div>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">	
		<div class="row">
			<div class="col-xs-12 archive-start archive">
				<div class="row">
						<?php if ( have_posts() ) : ?>

						<header class="page-header">
							<?php
								the_archive_title( '<h1 class="page-title">', ' Craft Ideas' . '</h1>' );
								the_archive_description( '<div class="taxonomy-description">', '</div>' );
							?>
						</header><!-- .page-header -->

						<?php
						// Start the Loop.
						while ( have_posts() ) : the_post();
							// Responsive column resets mobile
							if (($wp_query->current_post) % 4 === 0) {
								echo '<div class="clearfix hidden-xs-block"></div>';
							}

							// Responsive column reset anything above mobile
							if (($wp_query->current_post) % 2 === 0) {
								echo '<div class="clearfix visible-xs-block"></div>';
							}

							/*
							 * Include the Post-Format-specific template for the content.
							 * If you want to override this in a child theme, then include a file
							 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
							 */
							get_template_part( 'template-parts/content', get_post_format() );

						// End the loop.
						endwhile;

						echo '<div class="col-xs-12">';
							// Previous/next page navigation.
							the_posts_pagination( array(
								'prev_text'          => __( 'Previous page', 'twentysixteen' ),
								'next_text'          => __( 'Next page', 'twentysixteen' ),
								// 'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'twentysixteen' ) . ' </span>',
							) );
						echo '</div>';

					// If no content, include the "No posts found" template.
					else :
						get_template_part( 'template-parts/content', 'none' );

					endif;
					?>
				</div>
			</div>
		</div>

		</main><!-- .site-main -->
	</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
