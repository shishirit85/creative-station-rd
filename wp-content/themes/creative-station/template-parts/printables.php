
<!-- All subcategories for each parent category -->
<?php
// Category landing page content should be determined by slug.
// The landing page and parent category should share the same slug.

// Retrieve the category object
// Use landing page slug to determine which parent category to use
$menuLocations = get_nav_menu_locations();
$menuID = $menuLocations['primary'];
$menu_items = wp_get_nav_menu_items($menuID);
// $terms = get_terms(array("fields"=>"slugs"));
 
    // create an empty string which we will add onto
    $slider_items = Array();
 
    // loop through array and build list of navigation links
    for ( $x = 1; $x < count( $menu_items ); $x++ ) {
        
        if (strpos($menu_items[ $x ]->url, "bakerross.co.uk") !== false){
        // get URL of menu item
       $slider_items += [$menu_items[ $x ]->title => $menu_items[ $x ]->url];
    }
    }
    unset($slider_items["Printables"])
?>
    
        <div class="top-ideas bakerross-carousel row">
            <h2 class="dotted-lines">FREE Printables</h2>
            <button class="prev slick-arrow"></button>
            <button class="next slick-arrow"></button>
            <div class="top-ideas-slider">
            <?php foreach($slider_items as $title => $url): ?>
                    <div>                        
                    <a href="<?php echo esc_url($url); ?>" title="<?php echo $title; ?>">                        
                            <?php 
                            if ($title=="St David's Day"){
                                $search_url = "std";
                            } elseif ($title=="St Patrick's Day"){
                                $search_url="stp";
                            } else {
                            $search_url = parse_url($url); 
                            $search_url=ltrim($search_url['path'], '/');
                            $search_url=preg_split("[-]",$search_url);
                            $search_url= $search_url[0];
                            // $search_term = '';
                            // $search_term = reset(preg_grep($search_url, $terms));
                            };
                            ?>
                            <img data-lazy="<?php echo get_bloginfo('template_directory') . "/images/printables/{$search_url}.jpg'"; ?>" alt="<?php echo $title; ?>">
                        <!-- Category name and link -->
                        <a class="top-ideas-title" href="<?php echo esc_url($url); ?>" title="<?php echo $title; ?>"><?php echo $title; ?></a>
                    </a>
                </div>
            <?php endforeach; ?>    
            </div>        
        </div>



