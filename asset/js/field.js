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
        lazyLoad: 2,
        pageDots: true
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
                    initSliders[name] = initSlider('#' + id);
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
            reinitializedFlickity(newSlider.find('.slider-image'))
        }
    });

    function getGroupLastRow(element) {
        let table = $('#' + element.data('selector'));
        return table.find('.cmb-repeatable-grouping').last();
    }

    function reinitializedFlickity(imageChilds) {
        imageChilds.parent().parent().replaceWith(imageChilds);
        imageChilds.parent().find('button').remove();
        if (true === options.pageDots || !'pageDots' in options) {
            imageChilds.parent().find('ol').remove();
        }
        imageChilds.parent().removeClass('flickity-enabled');
        initSlider(imageChilds.parent())
    }

    function initSlider(selector) {
        let slider = $(selector).flickity(options);
        slider.on( 'change.flickity', function( event, index ) {
            storeSelectedElement(slider)
        });
        storeSelectedElement(slider);
        return slider;
    }

    function storeSelectedElement(slider) {
        let flkty = slider.data('flickity');
        let selected = flkty.selectedElement;
        slider.parent().find('input').val($(selected).attr('src'));
    }
    $('.ignorable').each(function () {
        ignoreField($(this));
    });

    $('.reverse-ignorable').each(function () {
        ignoreField($(this));
    });

    $('.connected').each(function () {
        uncheckOthers($(this));
    });


    $('.postbox').on('change',
        '.ignorable, .reverse-ignorable'
        , function () {
            ignoreField($(this));
        });

    function ignoreField(element, forceIgnore = false) {
        let input = element.find('input');
        if (input.length && !element.hasClass('already-checked')) {
            let targets = input.data('target');
            if (targets.length) {
                targets = targets.split(",");
                targets.forEach(function (item, index) {
                    item = $('#' + item.replace(/\s/g, ""));
                    if (item.length) {
                        let target = item.closest('.cmb-row');
                        if ((!input.prop('checked') && element.hasClass('ignorable')) || (input.prop('checked') && element.hasClass('reverse-ignorable')) || forceIgnore) {
                            if (target.hasClass('ignorable') || target.hasClass('reverse-ignorable')) {
                                ignoreField(target, true);
                                target.addClass('already-checked');
                            }
                            target.slideUp(250).addClass('cmb2-tab-ignore');
                        } else {
                            if (target.hasClass('ignorable') || target.hasClass('reverse-ignorable')) {
                                target.removeClass('already-checked');
                                ignoreField(target)
                            }
                            target.slideDown(250).removeClass('cmb2-tab-ignore');
                        }
                    }
                });
            }
        }
    }

    $('.postbox').on('change',
        '.connected'
        , function () {
            uncheckOthers($(this));
        });

    function uncheckOthers(element) {
        let input = element.find('input');
        let group = input.data('group');
        if (group.length && input.prop('checked')) {
            $('[data-group="' + group + '"').each(function () {
                let item = $(this);
                if (item.attr('id') !== input.attr('id')) {
                    item.closest('.connected').removeClass('disabled');
                    item.prop('checked', false).change();
                } else {
                    element.addClass('disabled')
                }
            })
        }
    }

    $('.postbox').on('click',
        '.depended'
        , function (e) {
            checkDependency($(this), e);
        });

    function checkDependency(element, event) {
        let input = element.find('input');
        let message = input.data('message');
        let targets = input.data('target');
        if (targets.length && !input.prop('checked')) {
            targets = targets.split(",");
            targets.forEach(function (item, index) {
                item = $('#' + item.replace(/\s/g, ""));
                if (item.length) {
                    let value = item.val();
                    if (value.length < 0 || value == 0) {
                        event.preventDefault();
                        event.stopPropagation();
                        alert(message);
                    }
                }
            });
        }
    }
});