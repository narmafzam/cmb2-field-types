require('../scss/field.scss');

import $ from "jquery";

import jQueryBridget from "jquery-bridget";
import Flickity from "flickity";
import "flickity-imagesloaded";
import "flickity-fullscreen";
import "flickity-as-nav-for";
import "flickity-fade";

$(document).ready(function () {
    let options = {
        rightToLeft: true,
        lazyLoad: 2
    };
    Flickity.setJQuery($);
    jQueryBridget('flickity', Flickity, $);
    let initSliders = {};
    let observer = new MutationObserver(function (mutations) {

        $('.slider-type').each(function (index, item) {
            if (isInViewport($(item))) {
                let id = item.id;
                let name = $(item).attr('name').split('[')[0];
                let alreadyExist = name in initSliders;
                if (!alreadyExist) {
                    let slider = $('#' + id).flickity(options);
                    slider.on( 'change.flickity', function( event, index ) {
                        let flkty = slider.data('flickity');
                        let selected = flkty.selectedElement;
                        slider.find('input').val($(selected).attr('src'));
                    });
                    initSliders[name] = slider;
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

    $('body').on('click', '.cmb-add-group-row', function () {
        let newSlider = getGroupLastRow($(this)).find('.slider-type');
        if (newSlider.length > 0 && newSlider.hasClass('flickity-enabled')) {
            destroyFlickity(newSlider.find('.slider-image'))
        }
    });

    function getGroupLastRow(element) {
        let table = $('#' + element.data('selector'));
        return table.find('.cmb-repeatable-grouping').last();
    }

    function destroyFlickity(imageChilds) {
        //slider-type flickity-enabled flickity-rtl is-draggable
        imageChilds.parent().parent().replaceWith(imageChilds);
        imageChilds.parent().find('button').remove();
        imageChilds.parent().removeClass('flickity-enabled');
        imageChilds.parent().flickity(options)
    }

});