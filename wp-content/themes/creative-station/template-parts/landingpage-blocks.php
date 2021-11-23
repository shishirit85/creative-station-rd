<?php
/**
 * Display main three categories with there assigned
 * category image and a link to the landing page.
 */

$parentCategories = getParentCategories();
?>

<div class="row landingpage-blocks">
    <?php foreach($parentCategories as $parentCategory): ?>
        <?php $categoryImage = get_field('category_image', 'category'. '_' . $parentCategory->cat_ID); ?>
        <div class="col-xs-12 col-sm-4 no-gutter-sm <?php echo get_field('category_style', 'category'. '_' . $parentCategory->cat_ID); ?>">
            <div>
                <?php if($categoryImage): ?>
                    <a href="<?php echo get_site_url() . '/' . $parentCategory->slug ?>"><h2>Ideas For <?php echo $parentCategory->name; ?></h2>
                        <img class="hidden-xs" src="<?php echo $categoryImage['url']; ?>"/>
                    </a>
                <?php else: ?>
                    <a href="<?php echo get_site_url() . '/' . $parentCategory->slug ?>"><h2>Ideas For <?php echo $parentCategory->name; ?></h2>
                        <img class="hidden-xs" src="<?php echo get_bloginfo('template_directory') . '/images/Placeholder.png'; ?>" alt="Placeholder image">
                    </a>
                <?php endif ?>
            </div>
        </div>
    <?php endforeach; ?>
</div>