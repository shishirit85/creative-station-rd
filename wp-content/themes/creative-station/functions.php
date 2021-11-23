<?php


function register_jquery()
{
	if (!is_admin() && $GLOBALS['pagenow'] != 'wp-login.php') {
		// comment out the next two lines to load the local copy of jQuery
		// wp_deregister_script('jquery');
		// wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js', false, '1.11.2');
		wp_enqueue_script('jquery');
	}
}
add_action( 'wp_enqueue_scripts', 'register_jquery' );

$css_timestamp = filemtime( get_stylesheet_directory().'/style.css' );
define( 'THEME_VERSION', $css_timestamp );

/**
 * Add scripts and styles here
 */
function creativestation_scripts()
{
	// Register main style sheet
	wp_register_style( 'creativestation-style', get_template_directory_uri() . '/style.css', array(), THEME_VERSION, 'all' );
	wp_enqueue_style( 'creativestation-style' );

	// Register bootstrap
	wp_register_style( 'bootstrap-css', get_template_directory_uri() . '/bootstrap/css/bootstrap.min.css', array(), '20120208', 'all' );
	wp_enqueue_style( 'bootstrap-css' );

	wp_register_script( 'bootstrap-scripts', get_template_directory_uri() . '/bootstrap/js/bootstrap.min.js' );
	wp_enqueue_script( 'bootstrap-scripts' );
	
	wp_enqueue_script('lozad', get_template_directory_uri() . '/lozad/lozad.min.js');

	// wp_register_style( 'bootstrap-small', get_template_directory_uri() . '/bootstrap.min.css' );
	// wp_enqueue_style( 'bootstrap-small' );


	// Register owl carousel 2
	// wp_register_style( 'owl-css', get_template_directory_uri() . '/owlcarousel2/css/owl.carousel.css', array(), '20120208', 'all' );
	// wp_enqueue_style( 'owl-css' );

	// wp_register_script( 'owl-scripts', get_template_directory_uri() . '/owlcarousel2/js/owl.carousel.min.js' );
	// wp_enqueue_script( 'owl-scripts' );

	wp_register_script( 'js-cookie', get_template_directory_uri() . '/julien-js-storage/js.cookie-2.2.1.min.js' );
	wp_enqueue_script( 'js-cookie' );

	// Same as jquery storage plugin API that Magento uses. Just vanilla JS though.
	wp_register_script( 'js-storage', get_template_directory_uri() . '/julien-js-storage/js-storage.min.js', ['js-cookie'] );
	wp_enqueue_script( 'js-storage' );

	// Underscore js
	// wp_register_script( 'underscore', get_template_directory_uri() . '/underscore/underscore-min.js' );
	// wp_enqueue_script( 'underscore' );

	// Register mmenu
	wp_register_style( 'mmenu-css', get_template_directory_uri() . '/mmenu/css/jquery.mmenu.all.css', array(), '20120208', 'all' );
	wp_enqueue_style( 'mmenu-css' );

	wp_register_script( 'mmenu-scripts', get_template_directory_uri() . '/mmenu/js/jquery.mmenu.all.min.js' );
	wp_enqueue_script( 'mmenu-scripts' );

	wp_register_script( 'mage-cart', get_template_directory_uri() . '/js/mage-cart-new.js', ['underscore', 'js-storage'], THEME_VERSION );
	wp_enqueue_script( 'mage-cart' );
	// wp_register_script( 'mage-cart', get_template_directory_uri() . '/js/mage-cart-new-test.js', ['underscore', 'js-storage'],"20211105" );
	// wp_enqueue_script( 'mage-cart' );

	wp_register_script('slick', get_template_directory_uri() . '/slick/slick.min.js', ['jquery']);
	wp_enqueue_script('slick');

	wp_register_style('slickcss', get_template_directory_uri() . '/slick/slick.css' );
	wp_enqueue_style('slickcss');

}
add_action( 'wp_enqueue_scripts', 'creativestation_scripts' );

/**
 * Register strings to translate
 */

;

/**
 * Register sidebars
 */
register_sidebar( array(
	'name'          => 'Single Post Sidebar',
	'id'            => 'sidebar-1',
	'description'   => 'Appears on the right side of single posts',
	'before_widget' => '<section id="%1$s" class="widget %2$s">',
	'after_widget'  => '</section>',
	'before_title'  => '<h4 class="widget-title-single">',
	'after_title'   => '</h4>',
) );

register_nav_menus( array(
	'primary' => __( 'Primary Menu', 'twentysixteen' ),
) );

/**
 * Register our sidebars and widgetized areas.
 */
function relatedposts_widgets_init()
{

	register_sidebar( array(
		'name'          => 'Home right sidebar',
		'id'            => 'home_right_1',
		'before_widget' => '<div>',
		'after_widget'  => '</div>',
		'before_title'  => '<h2 class="rounded">',
		'after_title'   => '</h2>',
	) );

}

/**
 * Retrive all parent categories excluding 'uncategorized'.
 *
 * @return mixed
 */
function getParentCategories()
{
	$array = array(1, 2, 3);
	$parentCategories = get_categories( array(
		'orderby' => 'name',
		'parent'  => 0,
		'exclude' => array(7, 1) // This is the ID of the category 'uncategorized'
	) );

	foreach($parentCategories as $parentCategory) {
        $categoryStyle = $parentCategory->cat_name;

		switch($categoryStyle) {
			case 'Kids':
				$array[0] = $parentCategory;
				break;
			case 'Teachers':
				$array[1] = $parentCategory;
				break;
			case 'Grown-ups':
				$array[2] = $parentCategory;
				break;
			default:
				break;
		}
	}

    return $array;
}

/**
 * @param string $fieldData
 * @return array $products
 */
function parseProducts($fieldData)
{
    $skus = '';
    $products = [];

    if ($fieldData)
    {
        $skus = explode(',', $fieldData);
    }

    return $skus;
}

function getHost()
{
	$server = $_SERVER['HTTP_HOST'];
	if (preg_match('*uat*', $server)){
		return 'https://uat.bakerross.co.uk';
	}
	elseif (preg_match('*ie*', $server)){
		return 'https://www.bakerross.ie';
	}
    else{
		return 'https://www.bakerross.co.uk';
	}
}

/**
 * URL to load customer section data.
 *
 * @return string
 */
function getCustomerSectionUrl()
{
    return getHost() . '/customer/section/load?sections=cart';
}

/**
 * Add to cart URL for Magento store.
 *
 * @return string
 */
function addToCartFormAction()
{
    return getHost() . '/customer_order/sku/uploadFile';
}

/**
 * Get Magento cart URL.
 *
 * @return string
 */
function getCartUrl()
{
    return getHost() . '/checkout/cart?utm_source=CreativeStation&utm_medium=AddToBasket';
}

/**
 * Get url of controller action to load product data.
 *
 * @return string
 */
function getProductsLoadUrl()
{
    return getHost() . '/blog_cart/product/index';
}

/**
 * Hash SKUs so they can be verified on Magento side as a valid request.
 *
 * @param $skus
 * @return string
 */
function getRequestkey($skus)
{
    return hash_hmac( 'sha256', $skus, 'mVW9l4JLr!X&fmBJcJhj' );
}

/**
 * Get correct header banner depending on page, category etc.
 *
 * @param bool $isMobile
 */
function getHeaderBanner($isMobile = false)
{
	// $currentLanguage = pll_current_language();
	$mobile = '';

	if($isMobile) {
		$mobile = '-mobile';
	}

	if(is_page() && !is_front_page()) {
		$style = get_field('category_style');

		switch($style) {
			case 'kids':
				echo '<img src="' . get_bloginfo('template_directory') . '/images/crafts-for-kids' . $mobile . '.png" alt="Creative Station Kids" class="img-responsive">';
				break;
			case 'teachers':
				echo '<img src="' . get_bloginfo('template_directory') . '/images/crafts-for-teachers' . $mobile . '.png" alt="Creative Station Teachers" class="img-responsive">';
				break;
			case 'grown-ups':
				echo '<img src="' . get_bloginfo('template_directory') . '/images/crafts-for-grown-ups' . $mobile . '.png" alt="Creative Station Grown-ups" class="center-block img-responsive">';
				break;
			default:
				break;
		}
		return;
	}

	// switch($currentLanguage) {
	// 	case 'nl':
	// 		echo '<a class="default-banner" href="' . esc_url(pll_home_url()) . '"><img src="' . get_bloginfo('template_directory') . '/images/nl-creative-station.png" alt="Creative Station Grown-ups" class="center-block img-responsive"></a>';
	// 		break;
	// 	case 'fr':
	// 		echo '<a class="default-banner" href="' . esc_url(pll_home_url()) . '"><img src="' . get_bloginfo('template_directory') . '/images/fr-creative-station.png" alt="Creative Station Grown-ups" class="center-block img-responsive"></a>';
	// 		break;
	// 	case 'de':
	// 		echo '<a class="default-banner" href="' . esc_url(pll_home_url()) . '"><img src="' . get_bloginfo('template_directory') . '/images/de-creative-station.png" alt="Creative Station Grown-ups" class="center-block img-responsive"></a>';
	// 		break;
	// 	case 'it':
	// 		echo '<a class="default-banner" href="' . esc_url(pll_home_url()) . '"><img src="' . get_bloginfo('template_directory') . '/images/it-creative-station.png" alt="Creative Station Grown-ups" class="center-block img-responsive"></a>';
	// 		break;
	// 	default:
	// 		echo '<a class="default-banner" href="' . esc_url(pll_home_url()) . '"><img src="' . get_bloginfo('template_directory') . '/images/default-creative-station.png" alt="Creative Station Grown-ups" class="center-block img-responsive"></a>';
	// 		break;
	// }

	return;
}

/**
 * Return class name to style page according
 * to the category.
 *
 * @return string
 */
function getPageBodyClass()
{
	if(is_front_page() || is_search()) {
		return;
	}

	$style = get_field('category_style');

	switch($style) {
		case 'kids':
			return 'kids';
			break;
		case 'teachers':
			return 'teachers';
			break;
		case 'grown-ups':
			return 'grown-ups';
			break;
		default:
			break;
	}
}

/**
 * Fallback function to always find a toplevel category.
 * As posts can have multiple top levels we are grabbing
 * the first as there is no way to determine the "main" one.
 *
 * @return mixed
 */
function getTopLevelCategory()
{
    $categories = get_the_category();
    $topLevelCategories = array();

    foreach($categories as $category)
    {
        if ($category->parent == 0)
        {
            $topLevelCategories[] = $category;
        }
    }

    return $topLevelCategories[0];
}

/**
 * Prints different style button
 * depending on category style.
 *
 * @param $categoryStyle
 */
function getButton($categoryStyle, $url = null) {
    if (!$url) {
        $url = get_permalink();
    }

	switch($categoryStyle) {
		case 'kids':
			echo '<a class="btn link craft-it" href="'; echo $url; echo '">'; echo 'Craft-it!'; echo'</a>';
			break;
		case 'teachers':
			echo '<a class="btn link teach-it" href="'; echo $url; echo '">'; echo 'Craft-it!'; echo'</a>';
			break;
		case 'grown-ups':
			echo '<a class="btn link create-it" href="'; echo $url; echo '">'; echo 'Craft-it!'; echo'</a>';
			break;
	}
}

/**
 * Get slug at end of current URL.
 *
 * @return mixed
 */
function getCurrentUrlSlug()
{
	// Get the URL and remove trailing '/'
	$url = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

	$url = cleanUrl($url);

    $url = rtrim($url,"/");

    // Retrieve just the page slug from URL
	preg_match("/[^\/]+$/", $url, $slug);

	return $slug[0];
}

function cleanUrl($url) {
    $parts = parse_url($url);
    return $parts['scheme'] . '://' . $parts['host'] . $parts['path'];
}

/**
 * Get correct store link depending on which
 * language blog the user is on.
 *
 * @return string
 */
function getStoreLink() {

	return 'https://www.bakerross.co.uk';
}

/**
 * Category carousel for landing pages
 * Provide parent category and child category
 * as attributes to shortcode to retrieve categories
 * related to the child.
 *
 * @param $atts
 * @return string
 */
function category_carousel_shortcode($atts)
{
	ob_start();

	$category_carousel_atts = shortcode_atts( array(
		'parentcategory' => 'Teachers',
		'category' => 'teachers',
		'toplevel' => 'Kids',
	), $atts);

	$parentCategoryName = $category_carousel_atts['parentcategory'];
	$categoryName = $category_carousel_atts['category'];
	$toplevel = $category_carousel_atts['toplevel'];

	include(locate_template('template-parts/landingpage-carousel.php'));

	return ob_get_clean();
}
add_shortcode('category_carousel', 'category_carousel_shortcode');

/**
 * Adds three blocks to homepage
 * getting the three main categories
 * 'kids', 'teachers', 'grown-ups'.
 *
 * @return string
 */
function landingpage_blocks_shortcode()
{
	ob_start();

	get_template_part( 'template-parts/landingpage', 'blocks' );

	return ob_get_clean();
}
add_shortcode('landingpage_blocks', 'landingpage_blocks_shortcode');

/**
 * Add top ideas carousels
 * via a shortcode '[topideas]'
 *
 * @return string
 */
function topideas_shortcode($atts = [], $content = null, $tag = '')
{
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
	$topideas_atts = shortcode_atts(
        array(
            'category' => 'kids',
        ), $atts, $tag
    );
	ob_start();

    get_template_part( 'template-parts/top', 'ideas', $topideas_atts );

    return ob_get_clean();
}
add_shortcode('topideas', 'topideas_shortcode');


function recentprojects_shortcode($atts = [], $content = null, $tag = '')
{
	ob_start();
	$recentprojects_atts = shortcode_atts(
        array(
            'posts' => '[]',
			'title' => 'RECENT',
        ), $atts, $tag
    );

	get_template_part( 'template-parts/recent', 'projects', $recentprojects_atts);

	return ob_get_clean();
	
}
add_shortcode('recentprojects', 'recentprojects_shortcode');

function topsubcategories_shortcode($atts = [], $content = null, $tag = '')
{
	ob_start();

	$topsubcategories_atts = shortcode_atts(
        array(
            'categories' => '[]',
			'categoryname' =>'',
        ), $atts, $tag
    );


	get_template_part( 'template-parts/top', 'subcategories', $topsubcategories_atts );

	return ob_get_clean();
	
}
add_shortcode('topsubcategories', 'topsubcategories_shortcode');

function allsubcategories_shortcode($atts = [], $content = null, $tag = '')
{
    $atts = array_change_key_case( (array) $atts, CASE_LOWER );
	$allsubcategories_atts = shortcode_atts(
        array(
            'category' => 'kids',
			'style' => 'category',
			'featured' => ''
        ), $atts, $tag
    );
	ob_start();

	get_template_part( 'template-parts/all', 'subcategories', $allsubcategories_atts);

	return ob_get_clean();
	
}
add_shortcode('allsubcategories', 'allsubcategories_shortcode');
/**
 * Add featured projects to a page
 * via a shortcode '[featured_projects]'
 *
 * @return string
 */
function featured_projects_shortcode()
{
    ob_start();

    get_template_part( 'template-parts/featured', 'projects' );

    return ob_get_clean();
}
add_shortcode('featured_projects', 'featured_projects_shortcode');

/**
 * Add featured projects to a page
 * via a shortcode '[featured_projects]'
 *
 * @return string
 */
function browse_by_category_shortcode()
{
    ob_start();

    get_template_part( 'template-parts/browse-by-category' );

    return ob_get_clean();
}
add_shortcode('browse_by_category', 'browse_by_category_shortcode');

function printables_shortcode()
{
    ob_start();

    get_template_part( 'template-parts/printables' );

    return ob_get_clean();
}
add_shortcode('printables', 'printables_shortcode');


function printable_menu_item($items) {
    global $wpdb;

    $printableSubMenu = '';

    // Get category IDs for all free printable cats.
    $freePrintableCategoryIds = [];
    $freePrintableCategories = $wpdb->get_results("SELECT * FROM {$wpdb->prefix}terms WHERE name = 'FREE Printables'", OBJECT);
    foreach ($freePrintableCategories as $freePrintableCategory) {
        $freePrintableCategoryIds[] = $freePrintableCategory->term_id;
    }

    // Get all posts assigned to a free printable category.
    $args = array(
        'category' => $freePrintableCategoryIds,
        'numberposts' => -1
    );

    $posts = get_posts($args);
    $menuCategories = [];

    // Grab all the category IDs associated with each post.
    foreach ($posts as $post) {
        $cats = wp_get_post_categories($post->ID, ['fields' => 'ids']);
        $menuCategories = array_merge($menuCategories, $cats);
    }

    // Remove free printable categories from menu.
    $menuCategories = array_diff($menuCategories, $freePrintableCategoryIds);

    // Load categories to be rendered into the menu.
    $menuCategories = get_categories(
        ['include' => array_unique($menuCategories)]
    );

    $menuItemNames = [];
    foreach ($menuCategories as $menuCategory) {
        $menuItemNames[$menuCategory->term_id] = $menuCategory->name;
    }

    // Get duplicated items from array.
    $counts = array_count_values($menuItemNames);
    $duplicates = array_filter($menuItemNames, function ($value) use ($counts) {
        return $counts[$value] > 1;
    });

    // For duplicates find out which one has the most free printable posts.
    $mostPostsDuplicates = [];
    foreach ($duplicates as $catId => $catName)
    {
        $maxPostCount = 0;
        foreach ($freePrintableCategoryIds as $freePrintableCategoryId) {
            $query = new WP_Query(['category__and' => [$catId, $freePrintableCategoryId]]);
            $postCount = $query->found_posts;

            if ($postCount > $maxPostCount) {
                $maxPostCount = $postCount;
            }
        }

        if (!isset($mostPostsDuplicates[$catName])) {
            $mostPostsDuplicates[$catName]['id'] = $catId;
            $mostPostsDuplicates[$catName]['posts'] = $maxPostCount;

            continue;
        }

        $currentMostPosts = $mostPostsDuplicates[$catName]['posts'];

        if ($maxPostCount > $currentMostPosts) {
            $mostPostsDuplicates[$catName]['id'] = $catId;
            $mostPostsDuplicates[$catName]['posts'] = $maxPostCount;
        }
    }

    // Build menu html
    foreach ($menuCategories as $menuCategory) {
        if ($menuCategory->name === 'Uncategorized') {
            continue;
        }

        // If category is a duplicate make sure we only render the one with most posts.
        if (isset($mostPostsDuplicates[$menuCategory->name])) {
            if ($mostPostsDuplicates[$menuCategory->name]['id'] !== $menuCategory->term_id) {
                continue;
            }
        }

        $categoryLink = rtrim(get_category_link($menuCategory->term_id), '/');
        $categoryLink .= '+free-printables/';

        $printableSubMenu .= sprintf(
            '<li><a href="%s">%s</a></li>',
            $categoryLink,
            $menuCategory->name
        );
    }

    $printableSubMenu = sprintf('<ul class="sub-menu"><li><ul class="sub-menu">%s</ul></li></ul>', $printableSubMenu);
    $printableMenuItem = sprintf(
        '<li class="col-xs-2 free-printables menu-item menu-item-type-post_type menu-item-object-page menu-item-has-children">
                    <a href="' . home_url( '/printables-club/' ) . '">' . __('FREE Printables') . '</a>%s</li>',
        $printableSubMenu
    );

    $items = $items . $printableMenuItem;
    return $items;
}
// add_filter( 'wp_nav_menu_items', 'printable_menu_item' );

/**
 * Add search form to menus		
 *
 * @param $items
 * @param $args
 * @return string
 */
function add_search_box( $items, $args ) {
	$items .= '<li class="search col-xs-3">' . get_search_form( false ) . '</li>';
	return $items;
}
add_filter( 'wp_nav_menu_items','add_search_box', 10, 2 );

/**
 * Filter to remove category prefix
 *
 * @return string
 */
add_filter( 'get_the_archive_title', function ($title) {

	if ( is_category() ) {

		$title = single_cat_title( '', false );

	} elseif ( is_tag() ) {

		$title = single_tag_title( '', false );

	} elseif ( is_author() ) {

		$title = '<span class="vcard">' . get_the_author() . '</span>' ;

	}

	return $title;

});

/**
 * Add a word limit to the excerpt
 *
 * @param $limit
 * @return array|mixed|string
 */
function excerpt($limit) {
	$excerpt = explode(' ', get_the_excerpt(), $limit);
	if (count($excerpt)>=$limit) {
		array_pop($excerpt);
		$excerpt = implode(" ",$excerpt).'...';
	} else {
		$excerpt = implode(" ",$excerpt);
	}
	$excerpt = preg_replace('`[[^]]*]`','',$excerpt);
	return $excerpt;
}

/**
 * Redirect archive pages if one post is available
 * under that category.
 */
//function redirect_to_post(){
//	global $wp_query;
//	if( is_archive() && $wp_query->post_count == 1 ){
//		the_post();
//		$post_url = get_permalink();
//		wp_redirect( $post_url );
//	}
//} add_action('template_redirect', 'redirect_to_post');

/**
 * Get root category of given category.
 *
 * @param string $category_id
 * @return mixed
 */
function get_root_category($category_id='')
{
	$mycat = get_term($category_id, 'category');
	$myparent = $mycat->parent;
	if ($myparent > 0) return get_root_category($myparent);
	else return $mycat->term_id;
}

/**
 * Builds custom post navigation based off a specific category id.
 *
 * @param $postId
 * @param $catId
 * @parm $category
 */
function getCustomPostNavigation($postId, $catId, $category = null)
{
	$args = array(
		'category' => $catId,
		'orderby'  => 'post_date',
		'order'    => 'DESC',
		'numberposts' => -1,
	);

	$posts = get_posts( $args );

	// get IDs of posts retrieved from get_posts
	$ids = array();
	foreach ( $posts as $thepost ) {
		$ids[] = $thepost->ID;
	}

	// get and echo previous and next post in the same category
	$thisindex = array_search( $postId, $ids );
	$previd = $ids[ $thisindex - 1 ];
	$nextid = $ids[ $thisindex + 1 ];

	$html = '';
	$html .= '<div class="row">';
	$html .= '<nav class="navigation post-navigation" role="navigation">';
	$html .= '<div class="nav-links">';

    $prevUrl = get_permalink($previd);
    if ($category) {
        $prevUrl = get_site_url() . '/' . $category->slug . '/' . basename(get_permalink($previd));
    }

    $nextUrl = get_permalink($nextid);
    if ($category) {
        $nextUrl = get_site_url() . '/' . $category->slug . '/' . basename(get_permalink($nextid));
    }

	if ( ! empty( $previd ) ) {
		$html .= '<div class="nav-previous">
							<a href="' . $prevUrl . '" rel="prev">
								<div class="col-xs-6">
								<span class="meta-nav" aria-hidden="true"></span> <span class="post-title">' . get_the_title($previd) . '</span>
								</div>
							</a>
						</div>';
	}
	if ( ! empty( $nextid ) ) {
		$html .= '<div class="nav-next">
							<a href="' . $nextUrl . '" rel="next">
								<div class="col-xs-6">
								<span class="meta-nav" aria-hidden="true"></span> <span class="post-title">' . get_the_title($nextid) . '</span>
								</div>
							</a>
						</div>';
	}
	$html .= '</div>';
	$html .= '</div>';
	$html .= '</nav>';

	echo $html;
}

/**
 * Takes youtube video url, extracts unique 11 character string which
 * is then used to return an embedded video.
 *
 * @param $url
 * @param $classes
 * @return string|void
 */
function embedYoutubeVideo($url, $classes = 'desktop')
{
	$values = getYoutubeId($url);
	return '<iframe class="video ' . $classes . '" src="https://www.youtube.com/embed/' . $values . '" srcdoc="<style>*{padding:0;margin:0;overflow:hidden}html,body{height:100%}img,span{position:absolute;width:100%;top:0;bottom:0;margin:auto}span{height:1.5em;text-align:center;font:48px/1.5 sans-serif;color:white;text-shadow:0 0 0.5em black}</style><a href=https://www.youtube.com/embed/' . $values . '><img src=https://img.youtube.com/vi/' . $values . '/hqdefault.jpg><span>▶</span></a>" frameborder="0" allowfullscreen loading="lazy"></iframe>';
}

function getYoutubeVideoThumb($url) {
	$values = getYoutubeId($url);

	if($values) {
		return '<img title="Youtube video thumbnail" class="img-responsive post-image wp-post-image" src="//img.youtube.com/vi/' . $values . '/0.jpg" />';
	}
}

function getYoutubeId($url) {
	// Get 11 digit code for video from url
	if (preg_match('/youtube\.com\/watch\?v=([^\&\?\/]+)/', $url, $id)) {
		return $values = $id[1];
	} else if (preg_match('/youtube\.com\/embed\/([^\&\?\/]+)/', $url, $id)) {
		return $values = $id[1];
	} else if (preg_match('/youtube\.com\/v\/([^\&\?\/]+)/', $url, $id)) {
		return $values = $id[1];
	} else if (preg_match('/youtu\.be\/([^\&\?\/]+)/', $url, $id)) {
		return $values = $id[1];
	}
	else if (preg_match('/youtube\.com\/verify_age\?next_url=\/watch%3Fv%3D([^\&\?\/]+)/', $url, $id)) {
		return $values = $id[1];
	} else {
		return;
	}
}

function getHeaderImage($category_name,$size){
	$base_dir = trailingslashit(get_template_directory());
	$dir      = "images/headers/category_headers_".$size ."/" ;
	if ($size == "mobile"){
		$category_name = strtoupper(($category_name));
	}
	$image   = glob($base_dir.$dir.$category_name.'.jpg');
	return get_theme_file_uri($dir.basename($image[0]));;
}

function gethomeheaders($size){
	$base_dir = trailingslashit(get_template_directory());
	$dir      = "images/headers/home_headers_".$size ."/" ;
	$images   = glob($base_dir.$dir.'*.jpg');
	return $images;
}

/**
 * Variable replacement for Yoast SEO plugin.
 * Returns parent category for current archive page.
 *
 * @param $parentCat
 * @return string $rootCategory | In this case 'Kids, Teachers, Grown-ups'
 */
function retrieve_parentcat_replacement( $parentCat ) {
	$currentCategory = get_category(get_query_var('cat'));
	$rootCategoryId = get_root_category($currentCategory->cat_ID);
	$rootCategory = get_the_category_by_ID($rootCategoryId);

	return $rootCategory;
}

/**
 * Register custom variable for Yoast SEO plugin.
 */
// function register_my_plugin_extra_replacements() {
// 	wpseo_register_var_replacement( '%%parentcat%%', 'retrieve_parentcat_replacement', 'advanced', 'Variable for parent category' );
// }
// add_action( 'wpseo_register_extra_replacements', 'register_my_plugin_extra_replacements' );

add_action( 'after_setup_theme', 'size_setup' );

function size_setup() {
    add_image_size( 'step-image', 300, 176 ); // 300 pixels wide (and unlimited height)
	add_image_size('slick-image', 270, 270);
}

function smartwp_remove_wp_block_library_css(){
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
    wp_dequeue_style( 'wc-block-style' ); // Remove WooCommerce block CSS
} 
add_action( 'wp_enqueue_scripts', 'smartwp_remove_wp_block_library_css', 100 );

/**
 * Disable the emoji's
 */
function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' ); 
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' ); 
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
	add_filter( 'wp_resource_hints', 'disable_emojis_remove_dns_prefetch', 10, 2 );
   }
   add_action( 'init', 'disable_emojis' );
   
   /**
	* Filter function used to remove the tinymce emoji plugin.
	* 
	* @param array $plugins 
	* @return array Difference betwen the two arrays
	*/
   function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
	return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
	return array();
	}
   }
   
   /**
	* Remove emoji CDN hostname from DNS prefetching hints.
	*
	* @param array $urls URLs to print for resource hints.
	* @param string $relation_type The relation type the URLs are printed for.
	* @return array Difference betwen the two arrays.
	*/
   function disable_emojis_remove_dns_prefetch( $urls, $relation_type ) {
	if ( 'dns-prefetch' == $relation_type ) {
	/** This filter is documented in wp-includes/formatting.php */
	$emoji_svg_url = apply_filters( 'emoji_svg_url', 'https://s.w.org/images/core/emoji/2/svg/' );
   
   $urls = array_diff( $urls, array( $emoji_svg_url ) );
	}
   
   return $urls;
   }

   
add_action( 'init', 'j0e_remove_large_image_sizes' );

function j0e_remove_large_image_sizes() {
  remove_image_size( '1536x1536' );             // 2 x Medium Large (1536 x 1536)
  remove_image_size( '2048x2048' ); 
  remove_image_size('medium_large');            // 2 x Large (2048 x 2048)
}

add_theme_support( 'post-thumbnails' );

function defer_parsing_js($url) {
	//Add the files to exclude from defer. Add jquery.js by default
		$exclude_files = array('jquery.min.js','lozad.min.js');
	//Bypass JS defer for logged in users
		if (!is_user_logged_in()) {
			if (false === strpos($url, '.js')){
				return $url;
			}
	
			foreach ($exclude_files as $file) {
				if (strpos($url, $file)) {
					return $url;
				}
			}
		} else {
			return $url;
		}
		return "$url' defer='defer";
	
	}
add_filter('clean_url', 'defer_parsing_js', 11, 1);


function remove_img_attr ($html)
{
    return preg_replace('/(width|height)="\d+"\s/', "", $html);
}
 
add_filter( 'post_thumbnail_html', 'remove_img_attr' );
add_filter('xmlrpc_enabled', '__return_false');
add_filter( 'feed_links_show_comments_feed','__return_false', 1 );

function wpse45941_disable_feed( $comments ) {
    if( $comments ) {
        wp_die( 'Feeds for comments have been disabled.', 410 );
    }
}
add_action('do_feed', 'wpse45941_disable_feed',1 );
add_action('do_feed_rdf', 'wpse45941_disable_feed',1 );
add_action('do_feed_rss', 'wpse45941_disable_feed',1 );
add_action('do_feed_rss2', 'wpse45941_disable_feed',1 );
add_action('do_feed_atom', 'wpse45941_disable_feed',1 );
add_action('do_feed_rss2_comments', 'wpse45941_disable_feed', 1);
add_action('do_feed_atom_comments', 'wpse45941_disable_feed', 1);
// remove_action('wp_head', 'feed_links_extra', 2);
// remove_action('wp_head', 'feed_links', 3);




add_action('init', 'remheadlink');

function remheadlink() {
remove_action('wp_head', 'rsd_link');
remove_action('wp_head', 'wlwmanifest_link');

}