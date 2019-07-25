require('../scss/field.scss');

import $ from "jquery";

import Flickity from "flickity";
import "flickity-imagesloaded";
import "flickity-fullscreen";
import "flickity-as-nav-for";
import "flickity-fade";

$(document).ready(function () {

    let observer = new MutationObserver(function (mutations) {

        $('.slider-type').each(function (index, item) {
            if (isInViewport(item)) {
                new Flickity('.slider-type', {
                    rightToLeft: true,
                    imagesLoaded: true,
                    pageDots: false,
                    fullscreen: true,
                    lazyLoad: true,
                    wrapAround: true,
                });
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