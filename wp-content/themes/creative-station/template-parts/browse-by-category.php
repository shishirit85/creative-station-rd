<?php
// Category landing page content should be determined by slug.
// The landing page and parent category should share the same slug.

// Retrieve the category object
// Use landing page slug to determine which parent category to use
$slug = getCurrentUrlSlug();

$parentCategory = get_category_by_slug($slug);

// Get the child of 'Teachers' which is 'Subjects'.
$topLevelSubCat = get_categories( array( 'child_of' => $parentCategory->cat_ID, 'parent' => $parentCategory->term_id  ));

foreach($topLevelSubCat as $topLevel) {
    // Get all of the subcategories of 'Subjects'.
    $subCategories = get_categories( array( 'child_of' => $topLevel->cat_ID ));
}
?>

<div class="row browse-by-category bakerross-carousel">
    <h2>Browse by Category</h2>
    <div class="owl-carousel">
        <?php foreach($subCategories as $subCategory): ?>
            <div>
                <a href="<?php echo esc_url(site_url('category/' . $subCategory->slug)); ?>" title="<?php echo $subCategory->name; ?>">

                    <?php $categoryImage = get_field('category_image', 'category'. '_' . $subCategory->cat_ID); ?>

                    <?php if($categoryImage): ?>
                        <!-- Image assigned to category -->
                        <img src="<?php echo $categoryImage['url']; ?>"/>
                    <?php else: ?>
                        <?php // Latest blog post image ?>
                        <?php $args = array(
                            'posts_per_page' => 1,
                            'offset' => 0,
                            'cat' => $subCategory->cat_ID,
                            'orderby' => 'post_date',
                            'order' => 'DESC',
                            'post_type' => 'post',
                            'post_status' => 'publish',
                        ); ?>
                        <?php
                        $the_query = new WP_Query( $args );
                        //$the_query->the_post();
                        if ( $the_query->have_posts() ) :
                            while ( $the_query->have_posts() ) : $the_query->the_post();
                                echo '<img src="'; the_post_thumbnail_url(); echo '"/>';
                            endwhile;
                        endif;
                        wp_reset_postdata();
                        ?>
                    <?php endif; ?>

                    <!-- Category name and link -->
                    <a class="link-arrow" href="<?php echo esc_url(site_url('category/' . $subCategory->slug)); ?>" title="<?php echo $subCategory->name; ?>"><?php echo $subCategory->name; ?></a>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script type="text/javascript">
    jQuery(document).ready(function($){
        $(".owl-carousel").owlCarousel({
            loop:true,
            margin:10,
            nav:true,
            navText: ['',''],
            responsive:{
                0:{
                    items:1
                },
                768:{
                    items:4
                },
                1000:{
                    items:4
                }
            }
        });
    });
</script>
