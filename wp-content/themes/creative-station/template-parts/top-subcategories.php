
<!-- Top subcategories for each parent category -->
<?php
// Category landing page content should be determined by slug.
// The landing page and parent category should share the same slug.

// Retrieve the category object
// Use landing page slug to determine which parent category to use
$slug = getCurrentUrlSlug();
$parentCategory = $args['categoryname'];
$categories = explode(",", $args['categories']);
$subCategories = get_categories( array( 
    // 'child_of' => $parentCategory->cat_ID,
    'number'=> '4',
    'orderby'=> 'include',
    'include' => $categories,   
) );
$ignoredSubcategories = ["cultures", "subjects", "techniques","themes-grown-ups"];
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
?>

        <div class="top-ideas bakerross-carousel row">
            <?php if ($parentCategory == "Seasons"):?>
                <h2 class="dotted-lines"><?php echo $parentCategory?></h2>
            <?php else: ?>
                <h2 class="dotted-lines">TOP <?php echo $parentCategory?></h2>
            <?php endif; ?>
            <button class="prev slick-arrow mobile"></button>
            <button class="next slick-arrow mobile"></button>
            <div class="mobile-slider">
            <?php foreach($subCategories as $subCategory): ?>
                <?php if (!in_array($subCategory->slug, $ignoredSubcategories)) :?>
                    <div>
                    <a href="<?php echo esc_url(site_url("category/" . $slug . "/" . $subCategory->slug)); ?>" title="<?php echo $subCategory->name; ?>">                        
                        <?php $categoryImage = get_term_meta($subCategory->term_id, 'category_image', true);?>
                        <?php $image = wp_get_attachment_image_src($categoryImage,'slick-image')?>
                        <img data-lazy="<?php echo $image[0];?>" alt="<?php echo get_the_title()?>"/>
                        <!-- Category name and link -->
                        <a class="top-ideas-title" href="<?php echo esc_url(site_url("category/" . $slug . "/" . $subCategory->slug)); ?>" title="<?php echo $subCategory->name; ?>"><?php echo $subCategory->name; ?></a>
                    </a>
                    </div>
                <?php endif;?>
            <?php endforeach; ?>    
            </div>        
        </div>

