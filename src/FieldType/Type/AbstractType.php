<?php

namespace FieldType\Type;

class AbstractType
{
    public static function init()
    {
        self::addAction();
        self::addFilter();

    }

    public static function addAction()
    {
        return;
    }

    public static function addFilter()
    {
        return;
    }

    public static function render($field, $value, $objectId, $objectType, $fieldType)
    {
        return;
    }

    public static function callback( $overrideValue, $value )
    {
        return;
    }
}