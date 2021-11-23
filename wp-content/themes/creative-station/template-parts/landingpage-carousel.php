<?php
$categoryObject = get_term_by('name', $categoryName, 'category');
$categoryId = $categoryObject->term_id;
$isPrintablePage = false;

$subCategories = get_categories( array( 'child_of' => $categoryId ));

if($parentCategoryName) {
    if ($parentCategoryName === 'FREE Printables') {
        $isPrintablePage = true;
        $printableCat = $parentCategoryObject = get_term_by('name', $parentCategoryName, 'category');
        $parentCategoryName = $toplevel ? $toplevel : 'Kids';
    }

    $parentCategoryObject = get_term_by('name', $parentCategoryName, 'category');

    $parentSubCategories = get_categories( array( 'child_of' => $parentCategoryObject->term_id ));

    // Find category within those subs
    foreach($parentSubCategories as $parentSubCategory) {
        if($categoryObject->name == $parentSubCategory->name) {
            $subCategories = get_categories( array( 'child_of' => $parentSubCategory->cat_ID ));
        }
    }
}

if ($isPrintablePage) {
    $subCatIds = [];
    $catIdsFromPrintablePosts = [];

    foreach ($subCategories as $subCategory) {
        // ALL sub categories of 'Activity' or other chosen cat.
        $subCatIds[] = $subCategory->cat_ID;
    }

    // ALL posts from FREE printables category.
    $args = array( 'category' => $printableCat->term_id );
    $posts = get_posts($args);
    foreach ($posts as $post) {
        $cats = wp_get_post_categories($post->ID, ['fields' => 'ids']);
        $catIdsFromPrintablePosts = array_merge($catIdsFromPrintablePosts, $cats);
    }

    // Categories found in both arrays gives us filtered cats
    $subCategories = get_categories(
            ['include' => array_intersect(array_unique($catIdsFromPrintablePosts), $subCatIds)]
    );
}
?>

<div class="row browse-by-category bakerross-carousel">
    <h2>Browse by <?php if ($isPrintablePage) {echo $toplevel;} ?> <?php echo $categoryObject->name; ?></h2>
    <div class="owl-carousel">
        <?php foreach($subCategories as $subCategory): ?>
            <div>
                <a href="<?php echo esc_url(site_url('category/' . $parentCategoryObject->slug .'/' . $subCategory->slug . '/')); ?>" title="<?php echo $subCategory->name; ?>">

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