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

            $attrs = $fieldType->parse_args( 'multibutton', array(
                'class'   => 'button ' . ( isset( $button['button'] ) && ! empty( $button['button'] ) ? 'button-' . $button['button'] : '' ),
                'id'      => $button_id,
            ) );

            $button_pattern = '<button type="button" %s>%s</button>';

            if( isset( $button['type'] ) && $button['type'] === 'link' ) {

                $href = 'javascript:void(0);';

                if( isset( $button['link'] ) ) {
                    $href = $button['link'];
                }

                if( isset( $button['target'] ) ) {
                    $attrs['target'] = $button['target'];
                }

                $button_pattern = '<a href="' . $href . '" %s>%s</a>';
            }

            $icon_html = '';

            if( isset( $button['icon'] ) && ! empty( $button['icon'] ) ) {
                $icon_html = '<i class="dashicons ' . $button['icon'] . '"></i>';
            }

            echo sprintf( $button_pattern,
                $fieldType->concat_attrs( $attrs ),
                $icon_html . ( isset( $button['label'] ) && ! empty( $button['label'] ) ? $button['label'] : '' )
            );
        }
    }

}