var Navigation;

( function( $ ) {
Navigation = {

    init: function ()
    {

        var navigation = $('.desktop-navigation');
        var navItems = navigation.find('> div > ul > li');
        this.events(navItems);

    },

    events: function (navItems)
    {

        navItems.on('mouseover', function ()
        {

            $(this).addClass('active');

        });

        navItems.on('mouseout', function ()
        {

            $(this).removeClass('active');

        });

    }

};

$(document).ready(function ()
{



    var mobileNavigation = $('.desktop-navigation').clone();
    $('body').append(mobileNavigation);

    mobileNavigation.attr('id', 'menu-location-');
    $('#menu-location-').mmenu(
        {

            "extensions": ["pagedim-black"]

        }
    );

    var API = $("#menu-location-").data("mmenu");

    // Add colour classes to bakerross link menus
    // var acceptedClasses = [
    //     'kids',
    //     'teachers',
    //     'grown-ups',
    //     'shop',
    //     'country-selector'
    // ];
    // $('#mm-1 li.menu-item').each(function (index, value)
    // {

    //     for (var i = 0; i < acceptedClasses.length; i = i + 1)
    //     {

    //         if ($(this).hasClass(acceptedClasses[i]))
    //         {

    //             var href = $(this).find('.mm-next').eq(0).attr('href');

    //             $(href).addClass(acceptedClasses[i]);

    //             $(href).find('.mm-next').each(function ()
    //             {

    //                 href = $(this).eq(0).attr('href');
    //                 $(href).addClass(acceptedClasses[i]);

    //             });

    //             break;

    //         }

    //     }

    // });

    $('.mm-menu .col-xs-2').removeClass('col-xs-2');
    $('.mm-menu .hide').removeClass('hide');

    // Hide search form from mmenu
    $('.mm-listview').find('.search-form').parent().hide();

    // Insert close menu button
    $('#mm-1 .mm-navbar').prepend('<a class="mm-close" href="#close"></a>');
    $('.mm-close').click(function ()
    {

        API.close();

    });

    // Remove boostrap top margin
    $('html').css("cssText", "margin-top: 0 !important;");

    // var changeHeight = function ()
    // {

    //     var blockOne = $('.latest.featured').find('.link-arrow').eq(0).height();
    //     var blockTwo = $('.latest.featured').find('.link-arrow').eq(2).height();

    //     if (blockOne > 0 && blockTwo > 0)
    //     {

    //         var featuredImageHeight = (blockOne + blockTwo) + 8;
    //         $('.featured').not('.latest').find('img').height(featuredImageHeight);

    //     }

    // };

    // changeHeight();
    // $(window).on('resize', function ()
    // {

    //     changeHeight();

    // });
    $(".mobile-home-slider").slick(
        {
            'dots': false,
            'arrows':false,
            'slidesToShow': 1,
            'slidesToScroll': 1,
            'infinite': true,
            'lazyLoad': 'progressive',
            'autoplay': true,
            'autoplaySpeed': 4000,
            'mobileFirst': true,
            // 'responsive': [
            //     {
            //         'breakpoint': 1024,
            //        'settings': "unslick"
            //     }
            //  ]

        }
    );
    var mobileslider = $(".mobile-slider:not(.slick-initialized)");
    mobileslider.each(function (idx, item)
    {
        // var carouselId = "carousel" + idx;
        // this.id = carouselId;
        console.log($(this))
        $(this).on("init.slick", function (event, slick) {
            $(this).parents('.top-ideas').find('.prev').css({display: "block"});
            $(this).parents('.top-ideas').find('.next').css({display: "block"});
        });
        
        $(this).slick(
            {
                'dots': false,
                'arrows': true,
                'slidesToShow': 4,
                'slidesToScroll': 1,
                'infinite': true,
                'lazyLoad': 'ondemand',
                'prevArrow': $(this).parents('.top-ideas').find('.prev'),
                'nextArrow': $(this).parents('.top-ideas').find('.next'),
                'responsive': [
                    {
                        'breakpoint': 790,
                        'settings': {
                            'dots': false,
                            'arrows': true,
                            'slidesToShow': 2,
                            'slidesToScroll': 2
                        }
                    },
                    {
                        'breakpoint': 1024,
                        'settings':'unslick'
                        // 'settings': {
                        //     'dots': false,
                        //     'arrows': false,
                        //     'slidesToShow': 4,
                        //     'slidesToScroll': 4
                        // }
                    },
                    // {
                    //     'breakpoint': 768,
                    //     'settings': {
                    //         'dots': false,
                    //         'arrows': true,
                    //         'slidesToShow': 2,
                    //         'slidesToScroll': 2
                    //     }
                    // }
                ]
            }
        );
    });
    
    $(".desktop-home-slider:not(.slick-initialized)").slick(
        {
            'dots': false,
            'arrows':false,
            'slidesToShow': 1,
            'slidesToScroll': 1,
            'infinite': true,
            'lazyLoad': 'progressive',
            'autoplay': true,
            'autoplaySpeed': 4000,
            'mobileFirst': true,
            // 'responsive': [
            //     {
            //        'breakpoint': 767,
            //        'settings': "unslick"
            //     },
            //     {
            //         'breakpoint': 1024,
            //         'settings': {
            //             'dots': false,
            //             'arrows': false,
            //             'slidesToShow': 1,
            //             'slidesToScroll': 1
            //         }
            //     }
            //  ]


        }
    )

});

$(window).on('load', function (){
    const observer = lozad('.lozad', {
        rootMargin: '100px 0px'}); // lazy loads elements with default selector as '.lozad'
    observer.observe();	
    var myCarousel = $(".top-ideas-slider:not(.slick-initialized)");
    myCarousel.each(function (idx, item)
    {
        // var carouselId = "carousel" + idx;
        // this.id = carouselId;
        console.log($(this))
        $(this).on("init.slick", function (event, slick) {
            $(this).parents('.top-ideas').find('.prev').css({display: "block"});
            $(this).parents('.top-ideas').find('.next').css({display: "block"});
        });
        
        $(this).slick(
            {
                'dots': false,
                'arrows': true,
                'slidesToShow': 4,
                'slidesToScroll': 1,
                'infinite': true,
                'lazyLoad': 'ondemand',
                'prevArrow': $(this).parents('.top-ideas').find('.prev'),
                'nextArrow': $(this).parents('.top-ideas').find('.next'),
                'responsive': [
                    {
                        'breakpoint': 768,
                        'settings': {
                            'dots': false,
                            'arrows': true,
                            'slidesToShow': 2,
                            'slidesToScroll': 2
                        }
                    },
                    {
                        'breakpoint': 1024,
                        'settings': {
                            'dots': false,
                            'arrows': true,
                            'slidesToShow': 2,
                            'slidesToScroll': 2
                        }
                    }
                ]
            }
        );
    });


    
});
})( jQuery );
