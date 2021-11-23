<?php
/**
 * The template for side bar on single posts
 */
?>

<?php
    $products = get_field('products');
    $skus = parseProducts($products);

    $latestIdeaContent = get_field('latest_idea_content');

    $category = null;
    $categoryName = explode('/', get_query_var('category_name'));
    if (!empty($categoryName)) {
        $category = get_category_by_slug($categoryName[0]);
        $categoryStyle = get_field('category_style', 'category'. '_' . $category->cat_ID);
        $parentCategoryId = $category->cat_ID;
    }
?>

<div class="loading-mask" id="sidebar-loader" data-role="loader" style="display: none;">
    <div class="loader">
        <img alt="Loading..." src=<?php echo get_bloginfo('template_directory') . '/images/loader-2.gif'; ?>>
    </div>
</div>

<?php if ($skus): ?>
    <div class="what-you-need-block">
        <h4><span>What you'll need</span></h4>

        <form id="add-to-cart" action="<?php echo addToCartFormAction(); ?>" class="loading add-to-cart" class="hidden">
            <input type="hidden" name="form_key" class="form-key">
            <?php foreach ($skus as $key => $sku): ?>
                <div class="product awaiting-update-desktop" id="<?php echo $sku; ?>">

                    <div class="product-image-container">
                        <div class="thumbnail">
                            <a href="" class="product-url">
                                <img />
                            </a>
                        </div>
                    </div>

                    <div class="product-info">
                        <div class="stock-status stock">
                            <span></span>
                        </div>

                        <div class="product-name">
                            <a href="" class="product-url"></a>
                        </div>

                        <div class="pack-size">
                        </div>

                        <div class="price-and-sku">
                            <div class="sku">
                                <?php echo $sku ?>
                                <input type="hidden" name="items[<?php echo $key; ?>][sku]" value="<?php echo $sku; ?>">
                            </div>

                            <div class="price-container">
                                <div class="price">
                                </div>

                                <div class="special-price">
                                </div>
                            </div>
                        </div>

                        <div class="field qty">
                            <label for="cart-<?php echo $sku; ?>-qty">
                                <span>Quantity</span>
                            </label>
                            <div class="control qty">
                                <span class="change-qty-btn decrease"></span>

                                <input
                                        id="cart-<?php echo $sku; ?>-qty"
                                        name="items[<?php echo $key; ?>][qty]"
                                        data-cart-item-id="<?php echo $sku; ?>>"
                                        value="1"
                                        type="number"
                                        size="4"
                                        title="Quantity"
                                        class="input-text qty"
                                >

                                <span class="change-qty-btn increase"></span>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>
            <?php endforeach; ?>

            <div class="actions">
                <div>
                    <div class="totals">
                        <span class="total-label">Total</span>
                        <span class="total">£0.00</span>
                    </div>

                    <button type="submit" title="Add to Basket" class="primary group tocart">
                        <span>Add to Basket</span>
                    </button>
                </div>
            </div>
        </form>
    </div>
<?php endif; ?>


<?php if ($skus && get_field('shopping_list')): ?>
    <div class="clearfix what-you-need <?php if (!$skus){echo 'no-skus';}?>"> 
    <p class="bold col-xs-12 title"><strong>Items you'll also need</strong></p>
     <?php echo get_field('shopping_list'); ?>
</div>
<?php elseif (get_field('shopping_list_2')): ?>
    <div class="clearfix what-you-need <?php if (!$skus){echo 'no-skus';}?>"> 
        <p class="bold col-xs-12 title"><strong>What you'll need</strong></p>
        <?php echo get_field('shopping_list_2'); ?>
    </div>
    <?php else: ?>
<?php endif;?>       



<div class="ideas-block" <?php if ($products) { echo 'style="display:none"'; } ?>>
    <?php if($latestIdeaContent == 'most-popular'): ?>
        <h4>Most Popular Ideas</h4>
    <?php else: ?>
        <h4><span>Latest</span> Ideas</h4>
    <?php endif; ?>

    <?php if($latestIdeaContent == 'most-popular'): ?>
        <?php $query = new WP_Query( array(
            'posts_per_page' => 7,
            'category__in' => $parentCategoryId,
            'orderby'    => 'post_views',
            'order'       => 'DESC',
            'post_type'   => 'post',
        ) ); ?>
    <?php else: ?>
        <?php $query = new WP_Query( array(
            'post_type' => 'post',
            'category__in' => $parentCategoryId,
            'posts_per_page' => 7
        ) ); ?>
    <?php endif; ?>

    <?php if ( $query->have_posts() ) : while ( $query->have_posts() ) : $query->the_post(); ?>

        <?php
            $url = get_permalink();
            if ($category) {
                $url = get_site_url() . '/' . $category->slug . '/' . basename(get_permalink());
            }
        ?>
        <div class="row">
            <a href="<?php echo $url; ?>" title="<?php the_title_attribute(); ?>">
                <div class="col-sm-3 col-sm-offset-3 col-md-6 col-md-offset-0 col-xs-12 ">
                    <?php if(has_post_thumbnail()): ?>
                        <?php the_post_thumbnail('thumbnail', array('class' => 'img-responsive center-block')); ?>
                    <?php else: ?>
                        <img class="img-responsive " src="<?php echo get_bloginfo('template_directory') . '/images/Placeholder.png'; ?>" alt="Placeholder image">
                    <?php endif; ?>
                </div>
                <div class="col-sm-3 col-md-6 col-xs-12 related-text">
                    <a href="<?php echo $url; ?>" title="<?php the_title_attribute(); ?>"><?php echo get_the_title(); ?></a>
                    <p><?php echo excerpt(10); ?></p>
                    <?php getButton('kids', $url); ?>
                </div>
            </a>
        </div>

    <?php endwhile; else: ?>
        No posts found
    <?php endif; ?>

    <?php wp_reset_query(); ?>
</div>