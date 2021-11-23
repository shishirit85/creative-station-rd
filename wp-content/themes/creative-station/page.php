<?php
/**
 * The template for displaying pages
 *
 * This is the template that displays all pages by default.
 * Please note that this is the WordPress construct of pages and that
 * other "pages" on your WordPress site will use a different template.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); 

$slug = getCurrentUrlSlug();
$category = get_category_by_slug($slug);
$categoryName = $category -> name;
?>


<?php if(!is_front_page()): ?>
<div class="category-header-mobile row">
	<?php $headerimage = getHeaderImage($categoryName, "mobile") ?>
	<img src="<?php echo $headerimage?>" alt="<?php echo $categoryName?>" class="category_image_mobile">
</div>

<div class="category-header row">
	<?php $headerimage = getHeaderImage($categoryName, "desktop") ?>	
	<img src="<?php echo $headerimage?>" alt="<?php echo $categoryName?>" class="category_image">
</div>
<?php endif; ?>

<?php if(is_front_page()): ?>
<div class="home-header-mobile row">
	<?php $mobileHeaders = gethomeheaders("mobile")?>
	<div class="mobile-home-slider">
		<?php foreach ($mobileHeaders as $key=>$header): ?>
			<?php if ($key === array_key_first($mobileHeaders)): ?>
				<div>
					<img src="<?php echo get_theme_file_uri("/images/headers/home_headers_mobile/".basename($header))?>" class="home_header_image_mobile">
				</div>
			<?php else: ?>
			<div>
				<img data-lazy="<?php echo get_theme_file_uri("/images/headers/home_headers_mobile/".basename($header))?>" class="home_header_image_mobile">
			</div>
			<?php endif; ?>
			<?php endforeach;?>
	</div>
</div>

<div class="home-header row">
<?php $desktopHeaders = gethomeheaders("desktop")?>
	<div class="desktop-home-slider">
		<?php foreach ($desktopHeaders as $key => $header): ?>
			<?php if ($key === array_key_first($desktopHeaders)): ?>
				<div>
					<img src="<?php echo get_theme_file_uri("/images/headers/home_headers_desktop/".basename($header))?>" class="home_header_image">
				</div>
			<?php else: ?>
			<div>
				<img data-lazy="<?php echo get_theme_file_uri("/images/headers/home_headers_desktop/".basename($header))?>" class="home_header_image">
			</div>
			<?php endif; ?>
			<?php endforeach;?>
	</div>	
</div>
<?php endif; ?>


<div id="primary" class="content-area">
	<main id="main" class="site-main" role="main">
		<?php
		// Start the loop.
		while ( have_posts() ) : the_post();

			// Include the page content template.
			get_template_part( 'template-parts/content', 'page' );

			// End of the loop.
		endwhile;
		?>

	</main><!-- .site-main -->

	<?php get_sidebar( 'content-bottom' ); ?>

</div><!-- .content-area -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
