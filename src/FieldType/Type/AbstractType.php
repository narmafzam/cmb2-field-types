<?php

namespace FieldType\Type;

abstract class AbstractType
{
    abstract public static function init();

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