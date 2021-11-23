<?php
    // Category landing page content should be determined by slug.
    // The landing page and parent category should share the same slug.

    // Retrieve the category object
    $slug = getCurrentUrlSlug();

    $parentCategory = get_category_by_slug($slug);
    $parentCategoryId = $parentCategory->cat_ID;

    $query = new WP_Query( array(
        'post_type' => 'post',
        'category__in' => $parentCategoryId,
        'posts_per_page' => 5
    ) );
?>

<div class="row">
    <?php // Loop one, Featured Project ?>
    <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

        <?php if($query->current_post == 0): ?>
            <div class="col-xs-12 col-sm-6 featured">
                <h2>Try our Featured Project</h2>
                <a href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                    <?php if(has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
                    <?php else: ?>
                        <img class="img-responsive" src="<?php echo get_bloginfo('template_directory') . '/images/Placeholder.png'; ?>" alt="Placeholder image">
                    <?php endif; ?>
                    <a  class="link-arrow" href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a>
                </a>
            </div>
        <?php endif; ?>

    <?php endwhile; else: ?>
        No posts found
    <?php endif; ?>

    <?php // Loop two, 4 other latest projects ?>
    <div class="col-xs-12 col-sm-6 latest featured">
        <h2>Our Latest Featured Projects</h2>
        <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

            <?php if($query->current_post != 0): ?>
                <div class="col-xs-6">
                    <a href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <?php if(has_post_thumbnail()): ?>
                            <?php the_post_thumbnail('full', array('class' => 'img-responsive')); ?>
                        <?php else: ?>
                            <img class="img-responsive" src="<?php echo get_bloginfo('template_directory') . '/images/Placeholder.png'; ?>" alt="Placeholder image">
                        <?php endif; ?>
                        <a class="link-arrow" href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a>
                    </a>
                </div>
            <?php endif; ?>

        <?php endwhile; else: ?>
            No posts found
        <?php endif; ?>
    </div>

    <?php wp_reset_query(); ?>
</div>