
<!-- All subcategories for each parent category -->
<?php
// Category landing page content should be determined by slug.
// The landing page and parent category should share the same slug.

// Retrieve the category object
// Use landing page slug to determine which parent category to use
$slug = getCurrentUrlSlug();
$category_title = $args['category'];
$style = $args['style'];
$featured = $args['featured'];
$parentCategory = get_category_by_slug($category_title);
$featuredCategory =get_category_by_slug($featured); 
if ($featured){
    $subCategories = get_categories( array( 
        'child_of' => $parentCategory->cat_ID,
        'exclude' => $featuredCategory -> term_id,
        ) 
    );  
    $subCategories = array_merge(array($featuredCategory),$subCategories);
} else{
    $subCategories = get_categories( array( 
        'child_of' => $parentCategory->cat_ID,
        ) 
    );  
}
$plurals = [
    "Occasion" => "Occasions",
    "Theme" => "Themes",
    "Activity" => "Activities",
    "Educational" => "Educational",
    "Adults" => "Adults",
    "Occasions" => "Occasions",
    "Themes" => "Themes",
    "Techniques" => "Techniques",
    "Seasons" => "Seasons",
    "Cultures" => "Cultures",
    "Subjects" => "Subjects"
];
$ignoredSubcategories = ["cultures", "subjects", "techniques","themes-grown-ups"]
?>
        <div class="top-ideas bakerross-carousel row">
            <h2 class="dotted-lines"><?php if($style == 'home'){echo $plurals[$parentCategory->name];} else { echo 'A-Z of ' , $plurals[$parentCategory->name];}?></h2>
            <button class="prev slick-arrow"></button>
            <button class="next slick-arrow"></button>
            <div class="top-ideas-slider">
            <?php foreach($subCategories as $subCategory): ?>
                <?php if (!in_array($subCategory->slug, $ignoredSubcategories)) :?>
                    <div>                        
                    <a href="<?php echo esc_url(site_url("category/" . $subCategory->slug)); ?>" title="<?php echo $subCategory->name; ?>">                        
                            <?php // Latest blog post image ?>
                            <?php $args = array(
                                'posts_per_page' => 1,
                                "numberposts" => 1,
                                'offset' => 0,
                                'category_name' => $subCategory->slug,
                                'orderby' => 'post_date',
                                'order' => 'DESC',
                                'post_type' => 'post',
                                'post_status' => 'publish',
                            ); ?>
                            <?php
                            $the_query = new WP_Query( $args );
                            //$the_query->the_post();
                                if ( $the_query->have_posts() ) :
                                    while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                                    <?php if(has_post_thumbnail()): ?>
                                     <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(),"slick-image"); ?>
                                    <img data-lazy="<?php echo $image[0];?>" alt="<?php echo get_the_title()?>"/>
                                    <?php endif; ?>
                                    <?php endwhile;
                                endif;
                            wp_reset_postdata();
                            ?>
                        <!-- Category name and link -->
                        <a class="top-ideas-title" href="<?php echo esc_url(site_url("category/" . $subCategory->slug)); ?>" title="<?php echo $subCategory->name; ?>"><?php echo $subCategory->name; ?></a>
                    </a>
                </div>
                <?php endif;?>
            <?php endforeach; ?>    
            </div>        
        </div>



