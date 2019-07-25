<?php

namespace FieldType;

use Generic\Asset as BaseClass;

class Asset extends BaseClass
{
    const FIELD_TYPE_SCRIPT = 'field-type-script';
    const FIELD_TYPE_STYLE  = 'field-type-style';

    public static function init()
    {
        self::addAction();
    }

    public static function addAction()
    {
        add_action('');
    }

    public static function enqueue()
    {
        $home = Utility::getHomeDirectoryName(__DIR__);
        wp_enqueue_script(
            self::FIELD_TYPE_SCRIPT,
            self::get('field.js', null, 's', "vendor/{$home}/b"),
            array('jquery')
        );
        wp_enqueue_style(
            self::FIELD_TYPE_STYLE,
            self::get('field.css', null, 's', "vendor/{$home}/b")
        );
    }
}