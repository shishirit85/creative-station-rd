var mageCart;
const products = {
    "product_data": {
      "EV170": {
        "sku": "EV170",
        "name": "A4 White Copier Card (Pack of 100)",
        "url": "https://uat.bakerross.co.uk/a4-white-copier-card",
        "pack_size": null,
        "price": "\u00a37.95",
        "special_price": "\u00a35.95",
        "status": "1",
        "stock_status": true,
        "thumbnail": "https://uat.bakerross.co.uk/media/catalog/product/cache/34e5c1ab67269cb2e9149f7dc1d31105/a/4/a4-white-copier-card-ag161z.jpg"
      },
  },
};
  
(function( $ ) {

mageCart = {

    addedSkus: [],
    outOfStockitems: [],

    customerSectionLoadUrl: '',
    productsLoadUrl: '',
    productData: '',
    skus: '',
    requestKey: '',

    selectors: {
        cartForm: '#add-to-cart',
        errorMessage: '.mage-error-messages',
        addToCartPopup: '#add-to-cart-popup',
        oosItemListContainer: '.out-of-stock-items-list',
        itemListContainer: '.added-items-list',
        loader: '#sidebar-loader',
        loaderMobile: '#sidebar-loader-mobile',
        productContainers: '.product',
        cartButton: '.tocart',
        qty: 'input.qty',
        specialPrice: '.special-price',
        price: '.price',
        total: '.totals .total',
        totalmobile: '.totalsmobile .total',
        minicartItemCount: '.counter-number',
        minicartSubtotal: '.minicart-subtotal',
        minicartLabel: '.counter-label',
        increaseQty: '.change-qty-btn.increase',
        decreaseQty: '.change-qty-btn.decrease',
    },

    templates: {
        addToCartError: _.template('<div><span><%= message.text.split("+").join(" ") %></span></div>'),
        addToCartPopupItemList: _.template('<ul><%_.each(items, function (item) {%><li><%= item %></li><% }); %></ul>'),
    },

    /**
     * Initialise cart functionality.
     *
     * @param customerSectionUrl
     * @param productsLoadUrl
     * @param skuString
     * @returns {mageCart}
     */
    init: function (customerSectionUrl, productsLoadUrl, skuString, requestKey) {
        // this.customerSectionLoadUrl = customerSectionUrl;
        // this.productsLoadUrl = productsLoadUrl;
        this.skus = skuString;
        // this.requestKey = requestKey;

        // this.formKeyInit();

        // this.toggleLoader();

        // $('body').on('customer-section-loaded', this.updateMiniCart.bind(this));

        // Fall back when no SKUs have been provided.
        if (!this.skus) {
            $('.what-you-need-block').hide();
            this.toggleLoader();
        }

            if (this.skus.length > 0) {
                    this.productData = products.product_data;
                    this.renderProductData();
                    this.renderProductDataMobile();
                    this.calculateTotals();
                    this.calculateTotalsMobile();
            }

        return this;
    },

    /**
     * Generate and set formkey cookie when it does not exist.
     * Done in the same manner as Magento in Magento_PageCache/js/page-cache
     *
     * @returns {mageCart}
     */
    formKeyInit: function () {
        var formkey = Storages.cookieStorage.get('form_key');

        if (!formkey) {

            var formkey = this.generateRandomString(
                '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ',
                16
            );

            Storages.cookieStorage.setPath('/').set('form_key', formkey);
        }

        return this;
    },

    /**
     * Helper. Generate random string
     * @param {String} chars - list of symbols
     * @param {Number} length - length for need string
     * @returns {String}
     */
    generateRandomString: function(chars, length) {
        var result = '';

        length = length > 0 ? length : 1;

        while (length--) {
            result += chars[Math.round(Math.random() * (chars.length - 1))];
        }

        return result;
    },

    /**
     * Set up event listeners.
     *
     * @returns {mageCart}
     */
    bindEvents: function () {
        $(this.selectors.cartForm).on('submit', this.submit.bind(this));
        $(this.selectors.increaseQty).on('click', this.qtyHandler.bind(this));
        $(this.selectors.decreaseQty).on('click', this.qtyHandler.bind(this));
        $(this.selectors.qty).on('change', this.validateQty.bind(this));
        $(this.selectors.qty).on('change', this.calculateTotals.bind(this));
        $(this.selectors.qty).on('change', this.disableAddToCart.bind(this));

        return this;
    },

    productDataLoad: function () {
        if (!this.skus) {
            console.error('Could not load product data no skus, provided.');
            return;
        }

        var deferred = new $.Deferred();

        $.ajax({
            type: "GET",
            url: this.productsLoadUrl,
            data: {
                timestamp: this.getRequestTimeStamp(),
                request_key: this.requestKey,
                skus: this.skus
            },
        })
            .done(function (response) {
                deferred.resolve(response);
            });

        return deferred.promise();
    },

    /**
     * Timestamp is used to break cache every hour.
     */
    getRequestTimeStamp: function () {
        var today = new Date();

        var time =  today.getFullYear().toString() + today.getMonth().toString() + today.getDay() + today.getHours();

        return time - 1;
    },

    /**
     * Handles updating of product listing markup.
     */
    renderProductData: function () {
        var productCount = $('.awaiting-update-desktop').length;
        var disabledProductCount = 0;
        var outOfStockCount = 0;
        console.log(this.productData)
        console.log(productCount)
        _.each(this.productData, function (product) {
            if (product.stock_status === false) {
                outOfStockCount++;
                this.outOfStockitems.push(product.name);
            }

            // Product is enabled
            if (product.status === '1') {
                var productContainer = $('.hidden-xs.col-sm-12.col-md-4 #' + product.sku);

                var stockMessage = product.stock_status ? 'in stock' : 'out of stock';
                var stockClass = product.stock_status ? 'available' : 'unavailable';

                productContainer.removeClass('awaiting-update-desktop');
                productContainer.addClass(stockClass);
                productContainer.addClass('desktop');
                productContainer.find('.product-name a').html(product.name);
                productContainer.find('.product-url').attr('href', product.url);
                productContainer.find('.stock-status').addClass(stockClass).html(stockMessage);
                productContainer.find('.pack-size').html(product.pack_size);
                productContainer.find('.price').html(product.price);
                productContainer.find('.special-price').html(product.special_price);
                productContainer.find('.thumbnail img').attr('src', product.thumbnail);

                if (!product.special_price) {
                    productContainer.find('.special-price').remove();
                } else {
                    productContainer.find('.price').addClass('was');
                }

                // Prevent out of stock items being added to cart.
                if (product.stock_status === false) {
                    productContainer.find('.qty').remove();
                    productContainer.find('.sku input').remove();
                }
            }
        }.bind(this));

        disabledProductCount = $('.awaiting-update-desktop').length;
        console.log(disabledProductCount)
        // Remove all the disabled products.
        $('.awaiting-update-desktop + hr').remove();
        $('.awaiting-update-desktop').remove();

        $(this.selectors.cartForm).removeClass('hidden');

        // Fall back to ideas block if needed.
        if (productCount === disabledProductCount || productCount === outOfStockCount || (disabledProductCount + outOfStockCount) === productCount) {
            $('.what-you-need-block').hide();
            $('.ideas-block').show();
            $('.what-you-need').addClass('no-skus');
        }
    },

    renderProductDataMobile: function () {
        var productCount = $('.awaiting-update-mobile').length;
        var disabledProductCount = 0;
        var outOfStockCount = 0;
       
        _.each(this.productData, function (product) {
            if (product.stock_status === false) {
                outOfStockCount++;
                this.outOfStockitems.push(product.name);
            }

            // Product is enabled
            if (product.status === '1') {
                var productContainer = $('.hidden-sm.hidden-md.hidden-lg #' + product.sku);
               
                var stockMessage = product.stock_status ? 'in stock' : 'out of stock';
                var stockClass = product.stock_status ? 'available' : 'unavailable';

                productContainer.removeClass('awaiting-update-mobile');
                productContainer.addClass(stockClass);
                productContainer.addClass('mobile');
                productContainer.find('.product-name a').html(product.name);
                productContainer.find('.product-url').attr('href', product.url);
                productContainer.find('.stock-status').addClass(stockClass).html(stockMessage);
                productContainer.find('.pack-size').html(product.pack_size);
                productContainer.find('.price').html(product.price);
                productContainer.find('.special-price').html(product.special_price);
                productContainer.find('.thumbnail img').attr('src', product.thumbnail);
                if (!product.special_price) {
                    productContainer.find('.special-price').remove();
                } else {
                    productContainer.find('.price').addClass('was');
                }

                // Prevent out of stock items being added to cart.
                if (product.stock_status === false) {
                    productContainer.find('.qty').remove();
                    productContainer.find('.sku input').remove();
                }
            }
        }.bind(this));
        disabledProductCount = $('.awaiting-update-mobile').length;

        // Remove all the disabled products.
        $('.awaiting-update-mobile + hr').remove();
        $('.awaiting-update-mobile').remove();

        $(this.selectors.cartForm).removeClass('hidden');

        // Fall back to ideas block if needed.
        if (productCount === disabledProductCount || productCount === outOfStockCount || (disabledProductCount + outOfStockCount) === productCount) {
            $('.what-you-need-block').hide();
            $('.ideas-block').show();
            $('.what-you-need').addClass('no-skus');
        }
    },

    /**
     * Load customer section data from Magento.
     * Returns a promise so actions can be taken after loading.
     *
     * @returns {*}
     */
    customerSectionLoad: function () {
        if (!this.customerSectionLoadUrl) {
            console.error('Could not load customer sections, no URL provided');
            return;
        }

        var deferred = new $.Deferred();

        // customer/section/load
        $.get(this.customerSectionLoadUrl)
            .done(function (response) {
                $('body').trigger('customer-section-loaded', [response]);

                deferred.resolve();
            });

        return deferred.promise();
    },

    /**
     * Add to cart form submission handler.
     * @param event
     */
    submit: function (event) {
        event.preventDefault();

        $('.form-key').val(Storages.cookieStorage.get('form_key'));

        this.toggleZeroQtyProducts(true);

        // Added skus are later used for add to cart popup.
        var formRequest = $(event.target).serializeArray();

        if (formRequest.length === 1) {
            var errorMessage = {type: 'error', text: 'Please select product quantities.'};
            var errorHtml = this.templates.addToCartError({ message: errorMessage });
            $(errorHtml).hide().appendTo(this.selectors.errorMessage).fadeIn(300);
            this.toggleZeroQtyProducts(false);

            return false;
        }

        _.each(formRequest, function (input) {
            if (input.name.indexOf('sku') !== -1) {
                this.addedSkus.push(input.value);
            }
        }.bind(this));

        $.ajax({
            type: "POST",
            url: $(event.target).attr('action'),
            data: formRequest,
        })
            .done(this.submissionDone.bind(this))
            .fail(this.submissionFail.bind(this));

        this.toggleLoader();
    },

    /**
     * Done callback for add to cart form submission.
     *
     * @param response
     */
    submissionDone: function (response) {
        this.customerSectionLoad().done(function () {
            // Same way Magento retrieves messages from cookie.
            var mageMessages = _.unique(Storages.cookieStorage.get('mage-messages'), 'text');
            var successMessages = [];
            var errorMessages = [];

            _.each(mageMessages, function (message) {
                if (message.type === 'success') {
                    successMessages.push(message);
                }

                if (message.type === 'error') {
                    errorMessages.push(message);
                }
            });

            if (errorMessages.length) {
                _.each(errorMessages, function (errorMessage) {
                    var errorHtml = this.templates.addToCartError({ message: errorMessage });
                    $(errorHtml).hide().appendTo(this.selectors.errorMessage).fadeIn(300);
                }.bind(this))
            }

            if (successMessages.length) {
                this.initAddToCartPopup();
            }

            // Default error if we don't get a message response back from add to cart request.
            if (mageMessages.length === 0) {
                this.appendDefaultErrorMessage();
            }

            // Clear added SKUs for next request.
            this.addedSkus = [];
            Storages.cookieStorage.setPath('/').set('mage-messages', '');

            this.toggleLoader();
            this.toggleZeroQtyProducts(false);
        }.bind(this));
    },

    /**
     * Fail callback for add to cart form submission.
     *
     * @param response
     */
    submissionFail: function (response) {
        this.appendDefaultErrorMessage();
    },

    /**
     * Update html of minicart with data from customer section load.
     *
     * @param event
     * @param customerData
     */
    updateMiniCart: function (event, customerData) {
        var cart = customerData.cart;
        var subtotal = cart.subtotal;
        var summaryCount = cart.summary_count;
        var label = summaryCount > 0 ? '( '+ summaryCount +' items )' : 'Your basket is empty.';

        $(this.selectors.minicartItemCount).html(summaryCount).show();
        $(this.selectors.minicartSubtotal).html(subtotal).show();
        $(this.selectors.minicartLabel).html(label);

        if (summaryCount === 0) {
            $(this.selectors.minicartItemCount).html(summaryCount).hide();
            $(this.selectors.minicartSubtotal).html(subtotal).hide();
        }
    },

    /**
     * Insert default error message on to page.
     *
     * @returns {mageCart}
     */
    appendDefaultErrorMessage: function () {
        var errorHtml = this.templates.addToCartError({ message: { text: 'There was a problem adding your items to basket.' } });
        $(errorHtml).hide().appendTo(this.selectors.errorMessage).fadeIn(300);

        return this;
    },

    /**
     * Launch add to cart popup. With rendered added items list.
     * Back drop has to be moved programatically to avoid layering issues.
     *
     * @returns {mageCart}
     */
    initAddToCartPopup: function () {
        var itemNames = [];

        _.each(this.addedSkus, function (sku) {
            var productContainer = $('input[value=' + sku + ']').parents('.product');
            var name = productContainer.find('.product-name').text().trim();
            var packsize = productContainer.find('.pack-size').text().trim();

            itemNames.push(name);
        });

        if (this.outOfStockitems.length > 0) {
            $(this.selectors.addToCartPopup + ' .no-out-of-stock').removeClass('no-out-of-stock');
            var outOfStockListHtml = this.templates.addToCartPopupItemList({ items: this.outOfStockitems });
            $(this.selectors.oosItemListContainer).html(outOfStockListHtml);
        }

        var itemListHtml = this.templates.addToCartPopupItemList({ items: itemNames });

        $(this.selectors.itemListContainer).html(itemListHtml);

        // Init modal
        $(this.selectors.addToCartPopup).modal({});
        $('.modal-backdrop').insertBefore(this.selectors.addToCartPopup);

        return this;
    },

    /**
     * Enable / Disable configured loader.
     *
     * @returns {mageCart}
     */
    // toggleLoader: function () {
    //     var loaderEl = $(this.selectors.loader);
    //     var loaderElMobile = $(this.selectors.loaderMobile);

    //     if (loaderEl.is(':visible') || loaderElMobile.is(':visible')) {
    //         loaderEl.hide();
    //         loaderElMobile.hide();
    //         return this;
    //     }

    //     loaderEl.show();
    //     loaderElMobile.show();

    //     return this;
    // },

    /**
     * Enable / Disable product inputs when qty == 0
     *
     * @param status
     * @returns {mageCart}
     */
    toggleZeroQtyProducts: function (status) {
        var availableProducts = $('.product.available');
        _.each(availableProducts, function (availableProduct) {
            var product = $(availableProduct);

            if (product.find('.input-text.qty').val() == 0) {
                product.find('input').attr('disabled', status);
            }
        });

        return this;
    },

    /**
     * Handler for qty adjustments via buttons.
     *
     * @param event
     */
    qtyHandler: function (event) {
        var target = $(event.target);
        var isIncrease = target.hasClass('increase');

        var value = $(event.target).parent().find('input').val();

        if (isIncrease) {
            value = parseInt(value) + 1;
            $(event.target).parent().find('input').val(value).trigger('change');

            return;
        }

        if (value > 0) {
            value = parseInt(value) - 1;
            $(event.target).parent().find('input').val(value).trigger('change');
        }
    },

    /**
     * Do not allow negative numbers in qty fields.
     *
     * @param event
     */
    validateQty: function (event) {
        var qtyField = $(event.target);

        if (qtyField.val() < 0 || qtyField.val() == '') {
            qtyField.val(0);
        }
    },

    /**
     * Update totals based on prices and qty.
     *
     * @returns {mageCart}
     */
    calculateTotals: function () {
        var total = 0.00;
        var currencySymbol = $('.price').eq(0).text().substring(0, 1);

        if (!this.productData) {
            return this;
        }

        $(this.selectors.cartForm + ' ' + this.selectors.productContainers + ':not(.unavailable)' +':not(.mobile)').each(function (key, value) {
            var priceSelector = this.selectors.price;

            if ($(value).find(this.selectors.specialPrice).length) {
                priceSelector = this.selectors.specialPrice;
            }

            var price = parseFloat($(value).find(priceSelector).text().match(/[\d\.\d]+/i)[0]);
            var qty = parseInt($(value).find(this.selectors.qty).val());

            if (isNaN(qty)) {
                qty = 0
            }

            var cost = price * qty;

            total += cost;
        }.bind(this));

        $(this.selectors.total).text(currencySymbol + total.toFixed(2));

        return this;
    },
    calculateTotalsMobile: function () {
        var total = 0.00;
        var currencySymbol = $('.price').eq(0).text().substring(0, 1);

        if (!this.productData) {
            return this;
        }

        $(this.selectors.cartForm + ' ' + this.selectors.productContainers + ':not(.unavailable)' + ":not(.desktop)").each(function (key, value) {
            var priceSelector = this.selectors.price;

            if ($(value).find(this.selectors.specialPrice).length) {
                priceSelector = this.selectors.specialPrice;
            }

            var price = parseFloat($(value).find(priceSelector).text().match(/[\d\.\d]+/i)[0]);
            var qty = parseInt($(value).find(this.selectors.qty).val());

            if (isNaN(qty)) {
                qty = 0
            }

            var cost = price * qty;

            total += cost;
        }.bind(this));

        $(this.selectors.totalmobile).text(currencySymbol + total.toFixed(2));

        return this;
    },

    /**
     * Disable add to cart if all qty values equal 0.
     *
     * @param event
     * @returns {mageCart}
     */
    disableAddToCart: function (event) {
        var disable = true;
        var qtyFields = $(this.selectors.qty);

        _.each(qtyFields, function (qty) {
            if (qty.value > 0) {
                disable = false;
            }
        });

        $(this.selectors.cartButton).prop('disabled', disable);

        return this;
    }
};
} )( jQuery );