
<?php
    // Category landing page content should be determined by slug.
    // The landing page and parent category should share the same slug.

    // Retrieve the category object
    $slug = getCurrentUrlSlug();
    $category = get_category_by_slug($slug);
    $categoryId = $category->cat_ID;
    $posts = explode(",", $args['posts']);
    $title = $args['title'];

    $query = new WP_Query( array(
        'post_type' => 'post',
        'posts_per_page' => 4,
        'post__in' => $posts,
        'orderby' => 'post__in'
    ) );   
?>
    <?php if(!empty($categoryId)): ?>
        <div class="top-ideas bakerross-carousel row">
            <h2 class="dotted-lines"><?php echo $title ?> Projects</h2>
            <button class="prev slick-arrow mobile"></button>
            <button class="next slick-arrow mobile"></button>
            <div class="mobile-slider">
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


