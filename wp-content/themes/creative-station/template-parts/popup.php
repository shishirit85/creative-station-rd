<div class="modal fade" id="add-to-cart-popup" tabindex="-1" role="dialog" aria-labelledby="add-to-cart-popup" aria-hidden="true" style="display: none">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button class="action-close" data-dismiss="modal" type="button">
                    <span></span>
                </button>
            </div>

            <div class="modal-body">
                <div class="no-out-of-stock">
                    <h2 class="fail-heading">
                        <span>These products are currently out of stock</span>
                    </h2>

                    <div class="out-of-stock-items-list">
                        <!-- Section is updated by an underscore.js template -->
                    </div>
                </div>

                <h2 class="success-heading">
                    <span>These products have been added to your basket</span>
                </h2>

                <div class="added-items-list">
                    <!-- Section is updated by an underscore.js template -->
                </div>
            </div>

            <div class="modal-footer">
                <div class="product-popup-actions">
                    <a href="#" class="button-primary white-bordered left-align" class="close" data-dismiss="modal" aria-label="Close"><span><span>Continue Shopping</span></span></a>
                    <a href="<?php echo getCartUrl(); ?>" class="action primary group tocart right-align"><span><span>View Basket</span></span></a>
                </div>
            </div>
        </div>
    </div>
</div>