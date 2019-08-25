<?php

namespace FieldType\Type;

class MultiButtonType extends AbstractType
{
    public static function init()
    {
        self::addAction();
        self::addFilter();
    }

    public static function addAction()
    {
        parent::addAction();
        add_action( 'cmb2_render_multi_buttons', 'FieldType\\Type\\MultiButtonType::render', 10, 5 );
    }

    public static function render($field, $escapedValue, $objectId, $objectType, $fieldType)
    {
        if( ! isset( $field->args['buttons'] ) ) {
            $field->args['buttons'] = array();
        }

        echo $fieldType->_desc( true );

        foreach( $field->args['buttons'] as $button_id => $button ) {

            echo ButtonType::generateButton('multibutton', $button, $fieldType);
        }
    }

}