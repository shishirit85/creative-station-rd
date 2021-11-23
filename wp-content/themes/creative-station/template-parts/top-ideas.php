
<!-- Top ideas for each parent category -->
<?php $parentCategories = getParentCategories(); ?>
<?php $category_title = $args['category'] ?>
<?php $category = get_category_by_slug($category_title); ?>
<?php $categoryID = $category->term_id; ?>

    <?php if(!empty($categoryID)): ?>
        <?php $query = new WP_Query( array(
            'post_type' => 'post',
            'category__in' => $categoryID,
            'posts_per_page' => 10
        ) ); ?>
    <?php endif; ?>

    <?php if(!empty($categoryID)): ?>
        <div class="top-ideas row">
            <div class="slider-header">
            <h2 class="dotted-lines"><?php echo get_cat_name($categoryID) ?></h2>
            </div>
            <button class="prev slick-arrow"></button>
            <button class="next slick-arrow"></button>
            <div class="top-ideas-slider">
                <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>
                    <div>
                        <a href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php if(has_post_thumbnail()): ?>
                            <?php $image = wp_get_attachment_image_src(get_post_thumbnail_id(),"slick-image"); ?>
                            <img data-lazy="<?php echo $image[0];?>" alt="<?php echo get_the_title()?>"/>
                        <?php else: ?>
                            <img src="<?php echo get_bloginfo('template_directory') . '/images/Placeholder.png'; ?>" alt="Placeholder image">
                        <?php endif; ?>
                        <a href="<?php echo the_permalink(); ?>" class="top-ideas-title" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a>
                        </a>
                    </div>

                <?php endwhile; else: ?>
                    No posts found
                <?php endif; ?>
            </div>
        </div>
    <?php endif; ?>

    <?php wp_reset_query(); ?>

