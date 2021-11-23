<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>

		</div><!-- .site-content -->

		<footer id="colophon" class="site-footer" role="contentinfo">
			<div class="container">
				<div class="row">
					<h1 class="tk-peachy-keen-jf">Get Daily INSPIRATION</p></h1>
					<p class="para">Follow us <strong>@bakerrossltd</strong> for inspiration and tag <strong>#BRCraftClub</strong> and <strong>#getkidscrafting</strong> for your chance to be featured on our grid</p>
					<div class="row footer-image-container">	
						<div class="col-sm-4 col-xs-6">
							<p class="image-credit">@margo_elsie_and_me</p>
							<img data-src="<?php echo get_bloginfo('template_directory') . '/images/footer/@margo_elsie_and_me.jpg'; ?>" alt="Bakerross logo" class="footer-image lozad">
						</div>
						<div class="col-sm-4 col-xs-6">
							<p class="image-credit">@alex_gladwin</p>
							<img data-src="<?php echo get_bloginfo('template_directory') . '/images/footer/@alex_gladwin.jpg'; ?>" alt="Bakerross logo" class="footer-image lozad" >
						</div>
						<div class="col-sm-4 hidden-xs">
							<p class="image-credit">@loganjamesp</p>
							<img data-src="<?php echo get_bloginfo('template_directory') . '/images/footer/@loganjamesp.jpg'; ?>" alt="Bakerross logo" class="footer-image lozad">
						</div>
					</div>
					<div class= "row footer-button">
							<h3><a href="https://linktr.ee/bakerross">Follow Us</a></h3>
					</div>
				</div>
			</div>
		</footer><!-- .site-footer -->
	</div><!-- .site-inner -->
</div><!-- .site -->

<?php wp_footer(); ?>

<?php get_template_part( 'template-parts/popup' ); ?>

<div class="loading-mask" id="page-loader" data-role="loader" style="display: none;">
    <div class="loader">
        <img alt="Loading..." src=<?php echo get_bloginfo('template_directory') . '/images/loader-2.gif'; ?>>
    </div>
</div>

<script src="<?php echo get_template_directory_uri() . '/js/scripts.js?'.THEME_VERSION; ?>"></script>
<link rel="stylesheet" href="https://use.typekit.net/pvn7lma.css"> 
<script type="text/javascript">
	Navigation.init();
</script>

<script type="text/javascript">
( function( $ ) {
	$(document).ready(function () {
        mageCart.init(
            '<?php echo getCustomerSectionUrl(); ?>',
            '<?php echo getProductsLoadUrl(); ?>',
            '<?php echo get_field('products'); ?>',
            '<?php echo getRequestKey(get_field('products')); ?>'
        )
            .calculateTotals()
			.calculateTotalsMobile();
	});
} )( jQuery );
</script>

</body>
</html>
