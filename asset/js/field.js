require('../scss/field.scss');

import $ from "jquery";

let jQuery = $;

import jQueryBridget from "jquery-bridget";
import Flickity from "flickity";
import "flickity-imagesloaded";
import "flickity-fullscreen";
import "flickity-as-nav-for";
import "flickity-fade";

$(document).ready(function () {
    let options = {
        rightToLeft: true,
        lazyLoad: true,
        pageDots: false
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

    function initSlider(selector) {
        let slider = $(selector).flickity(options);
        slider.each(function (index, item) {
            $(item).on('change.flickity', function (e) {
                storeSelectedElement($(item));
            });
        });
        storeSelectedElement(slider);
        return slider;
    }

    $('body').on('click', '.cmb-add-group-row', function () {
        let newSlider = $(this).getGroupSlider();
        if (newSlider.length > 0) {
            initSlider(newSlider);
        }
    });

    function storeSelectedElement(slider) {
        let selected = $(slider.data('flickity').selectedElement)
            .data('id');
        slider.parent().find('input').val(selected);
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

    $('.cmb2-metabox').on('change',
        '.ignorable, .reverse-ignorable'
        , function () {
            ignoreField($(this));
        });

    function ignoreField(element, forceIgnore = false) {
        let inputs;
        if (!element.is('input')) {

            inputs = element.find('input');
        } else {

            inputs = element;
        }
        inputs.each(function (index, input) {
            input = $(input);
            if (input.length > 0 && !element.hasClass('already-checked')) {
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
        });
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

(function ($) {
    $.fn.getGroupSlider = function () {
        let $this;
        $this = $(this);
        return $this.closest('.repeatable')
            .find('.slider-type');
    };
})(jQuery);