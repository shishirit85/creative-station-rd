<?php
// Get related project Id's
$relatedProjects = get_field('related_projects');
$relatedProjectsArray = explode(',', $relatedProjects);

// Query for related projects
$args = array(
    'posts_per_page'       => 4,
    'post_type'         => 'post',
    'meta_key'          => 'ID',
    'meta_value'        => $relatedProjectsArray
);

// query
$the_query = new WP_Query( $args );
?>

<?php if($relatedProjects): ?>
    <div class="row related-ideas">
        <div class="col-xs-12">
            <h2>Related Ideas</h2>
        </div>
        <?php if( $the_query->have_posts() ): ?>
            <?php while ( $the_query->have_posts() ) : $the_query->the_post(); ?>
                <div class="col-xs-6 col-sm-4 col-md-3">
                    <a href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>">
                        <!-- Thumbnail -->
                        <?php the_post_thumbnail('medium', array('class' => 'img-responsive')); ?>

                        <!-- Title -->
                        <a class="related-title" href="<?php echo the_permalink(); ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a>

                        <!-- Button -->
                        <?php
                        $categories = get_the_category();
                        foreach($categories as $category) {
                            if(get_field('category_style', 'category'. '_' . $category->cat_ID)) {
                                $categoryStyle = get_field('category_style', 'category'. '_' . $category->cat_ID);
                            }
                        }
                        ?>

                        <?php getButton($categoryStyle); ?>
                    </a>
                </div>
            <?php endwhile; ?>
        <?php endif; ?>
    </div>
<?php endif; ?>

<?php wp_reset_query(); ?>
