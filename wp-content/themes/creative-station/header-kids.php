<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html>
<html <?php language_attributes(); ?> class="no-js">
<head>
    <meta charset="<?php bloginfo( 'charset' ); ?>">
    <?php if(is_page()): ?>
        <title><?php the_field('meta_title'); ?></title>
        <meta name="description" content="<?php the_field('meta_description'); ?>" />
    <?php else: ?>
        <title><?php wp_title( '|', true, 'right' );?></title>
        <meta name="description" content="<?php bloginfo('description'); ?>" />
    <?php endif; ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="profile" href="http://gmpg.org/xfn/11">
    <?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
        <link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
    <?php endif; ?>
    <?php wp_head(); ?>
    <link rel="icon" type="image/png" href="http://www.bakerross.co.uk/skin/frontend/enterprise/bakerross/images/bakerross_symbol.png" />
    <script src="https://apis.google.com/js/platform.js" async defer></script>
    <script type="text/javascript" async defer src="//assets.pinterest.com/js/pinit.js"></script>
    <script async src="//bakerross.api.useinsider.com/ins.js?id=10003011"></script>
    <link rel="stylesheet" href="https://use.typekit.net/pvn7lma.css"> 

    <!-- Google Tag Manager -->
    <script>
        (function(w,d,s,l,i){w[l]=w[l]||[];w[l].push(
            {'gtm.start': new Date().getTime(),event:'gtm.js'}
        );var f=d.getElementsByTagName(s)[0],
            j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
            'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
        })(window,document,'script','dataLayer','GTM-T2NF33Z');
    </script>
    <!-- End Google Tag Manager -->
</head>

<body <?php body_class(); ?>>

<!-- Google Tag Manager (noscript) -->
<noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-T2NF33Z"
            height="0" width="0" style="display:none;visibility:hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) -->

<div id="fb-root"></div>

<div id="page" class="site">
    <div class="site-inner">

        <header id="masthead" class="site-header" role="banner">
            <div class="container-fluid">
                <div class="container">
                    <div class="row site-branding">
                        <div class="col-xs-12 header-box">
                            <div class="pull-left hidden-xs"><a href="<?php echo esc_url( pll_home_url() ); ?>"><img src="<?php echo get_bloginfo('template_directory') . '/images/bakerross_logo.png'; ?>" alt="Bakerross logo"></a></div>
                            <div class="pull-right hidden-xs">
                                <a class="shop-at-bakerross" href="<?php echo getStoreLink(); ?>"><?php pll_e('SHOP at Baker Ross'); ?></a>
                            </div>
                            <div class="minicart-wrapper">
                                <a class="action showcart" href="<?php echo getCartUrl(); ?>">
                                    <span class="counter qty">
                                        <span class="counter-number"></span>
                                        <span class="minicart-subtotal" style="display: none">
                                            <span class="price"></span>
                                        </span>
                                        <span class="counter-label">
                                            <span><?php pll_e('Your basket is empty'); ?></span>
                                        </span>
                                    </span>
                                </a>
                            </div>
                            <div class="pull-right visible-xs"><a class="shop-at-bakerross no-arrow" href="<?php echo getStoreLink(); ?>"><span><?php pll_e('SHOP'); ?></span></a></div>
                            <div class="pull-right visible-xs br-logo"><a href="<?php echo esc_url( pll_home_url() ); ?>"><img src="<?php echo get_bloginfo('template_directory') . '/images/bakerross_logo_mobile.png'; ?>" alt="Bakerross logo"></a></div>
                            <div class="pull-left visible-xs">
                                <a href="#menu-location-" id="menu-mobile"></a>
                            </div>
                        </div>
                    </div><!-- .site-branding -->
                </div>
            </div>

            <nav class="container-fluid desktop-navigation">
                <?php wp_nav_menu(array('menu_class' => 'container hidden-xs')); ?>
                <div class="mobile-search search visible-xs">
                    <?php get_search_form(); ?>
                </div>
            </nav>

        </header><!-- .site-header -->

        <div id="content" class="site-content container">
