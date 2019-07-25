require('../scss/field.scss');

import $ from "jquery";

import jQueryBridget from "jquery-bridget";
import Flickity from "flickity";
import "flickity-imagesloaded";
import "flickity-fullscreen";
import "flickity-as-nav-for";
import "flickity-fade";

$(document).ready(function () {

    Flickity.setJQuery( $ );
    jQueryBridget( 'flickity', Flickity, $ );

    let observer = new MutationObserver(function (mutations) {

        $('.slider-type').each(function (index, item) {
            if (isInViewport($(item))) {
                if (!$(item).hasClass('flickity-enabled')) {
                    let id = item.id;
                    let $carousel = $('#' + id).flickity({
                        rightToLeft: true,
                        imagesLoaded: true,
                        pageDots: false,
                        fullscreen: true,
                        lazyLoad: true,
                        wrapAround: true,
                    });

                    // new Flickity('#' + id, {
                    //     rightToLeft: true,
                    //     imagesLoaded: true,
                    //     pageDots: false,
                    //     fullscreen: true,
                    //     lazyLoad: true,
                    //     wrapAround: true,
                    // });
                }
            }
        });
    });
    observer.observe(document, {
        childList: true,
        subtree: true,
        attributes: true,
    });

    function isInViewport(element) {
        let elementTop = element.offset().top;
        let elementBottom = elementTop + element.outerHeight();

        let viewportTop = $(window).scrollTop();
        let viewportBottom = viewportTop + $(window).height();

        return elementBottom > viewportTop && elementTop < viewportBottom;
    }
});