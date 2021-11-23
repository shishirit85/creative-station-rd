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

<div class="loading-mask" id="sidebar-loader-mobile" data-role="loader" style="display: none;">
    <div class="loader">
        <img alt="Loading..." src=<?php echo get_bloginfo('template_directory') . '/images/loader-2.gif'; ?>>
    </div>
</div>

<?php if ($skus): ?>
    <div class="what-you-need-block">
        <div class="accordion" id="products_list">
                <div class="card">
                    <div class="card-header" id="products_list_header">   
                        <button class="btn btn-link btn-block text-left bold title" type="button" data-toggle="collapse" data-target="#products_list_items" aria-expanded="true" aria-controls="products_list"><strong>What you'll need <span class="caret"></span>
</strong></btn>
                    </div>
                    <div id="products_list_items" class="collapse" aria-labelledby="products_list_header" data-parent="#products_list">
                        <div class="card-body">
                            <form id="add-to-cart-mobile" action="<?php echo addToCartFormAction(); ?>" class="loading add-to-cart" class="hidden">
                                <input type="hidden" name="form_key" class="form-key">
                                <?php foreach ($skus as $key => $sku): ?>
                                    <div class="product awaiting-update-mobile" id="<?php echo $sku; ?>">
                                        <div class="product-image-container">
                                            <div class="thumbnail">
                                                <a href="" class="product-url">
                                                    <img class="lozad"/>
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
                                        <div class="totalsmobile">
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
                    </div>
                </div>
            </div>
        </div>
<?php endif; ?>


        <?php if ($skus && get_field('shopping_list')): ?>
            <div class="clearfix what-you-need <?php if (!$skus){echo 'no-skus';}?>"> 
            <div class="accordion" id="shopping_list">
                <div class="card">
                    <div class="card-header" id="shopping_list_header">   
                        <button class="btn btn-link btn-block text-left bold title" type="button" data-toggle="collapse" data-target="#shopping_list_items" aria-expanded="true" aria-controls="shopping_list"><strong>Items you'll also need <span class="caret"></span>
                </strong></button>
                    </div>
                    <div id="shopping_list_items" class="collapse" aria-labelledby="shopping_list_header" data-parent="#shopping_list">
                        <div class="card-body">
                            <?php echo get_field('shopping_list'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
            <?php elseif (get_field('shopping_list_2')): ?>
    <div class="clearfix what-you-need <?php if (!$skus){echo 'no-skus';}?>"> 
            <div class="accordion" id="shopping_list">
                <div class="card">
                    <div class="card-header" id="shopping_list_header">   
                        <button class="btn btn-link btn-block text-left bold title" type="button" data-toggle="collapse" data-target="#shopping_list_items" aria-expanded="true" aria-controls="collapseOne"><strong>What you'll need <span class="caret"></span>
</strong></button>
                    </div>
                    <div id="shopping_list_items" class="collapse" aria-labelledby="shopping_list_header" data-parent="#shopping_list">
                        <div class="card-body">
                            <?php echo get_field('shopping_list_2'); ?>
                        </div>
                    </div>
                </div>
            </div>
            </div>
            <?php else: ?>
        <?php endif;?>
        
    
