<?php

namespace FieldType\Type;

class ButtonType extends AbstractType
{
    public static function init()
    {
        self::addAction();
        self::addFilter();
    }

    public static function addAction()
    {
        parent::addAction();
        add_action( 'cmb2_render_button', 'FieldType\\Type\\ButtonType::render', 10, 5 );
    }

    public static function render($field, $value, $objectId, $objectType, $fieldType)
    {
        // Parse args
        $attrs = $fieldType->parse_args( 'button', array(
            'type'    => 'button',
            'name'    => $fieldType->_name(),
            'id'      => $fieldType->_id(),
            'class'   => 'button ' . ( isset( $field->args['button'] ) && ! empty( $field->args['button'] ) ? 'button-' . $field->args['button'] : '' ),
        ) );

        $button_pattern = '%s<button %s>%s</button>%s';

        if( isset( $field->args['action'] ) && ! empty( $field->args['action'] ) ) {
            $attrs['name'] = 'gamipress-action';
            $attrs['value'] = $field->args['action'];
            $attrs['type'] = 'submit';
        }

        $icon_html = '';

        if( isset( $field->args['icon'] ) && ! empty( $field->args['icon'] ) ) {
            $icon_html = '<i class="dashicons ' . $field->args['icon'] . '"></i>';
        }

        echo sprintf( $button_pattern,
            $fieldType->_desc( true ),
            $fieldType->concat_attrs( $attrs ),
            $icon_html . ( isset( $field->args['label'] ) && ! empty( $field->args['label'] ) ? $field->args['label'] : $field->args( 'name' ) ),
            ( isset( $field->args['message'] ) ? $field->args['message'] : "<span class='messate' id='{$fieldType->_id()}_message'></span>")

        );
    }
}