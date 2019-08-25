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
        echo self::generateButton('button', $field, $fieldType);
    }

    public static function generateButton($type, $button, $fieldType)
    {
        $attrs = $fieldType->parse_args( $type, array(
            'type'    => 'button',
            'element' => ( isset( $field->args['element'] ) && ! empty( $button['element'] ) ?  $button['element'] : 'button' ),
            'name'    => $fieldType->_name(),
            'id'      => $fieldType->_id(),
            'class'   => 'button ' . ( isset( $button['button'] ) && ! empty( $button['button'] ) ? 'button-' . $button['button'] : '' ),
        ) );

        if( isset( $button['action'] )
            && ! empty( $button['action'] ) ) {

            $attrs['name']  = 'pmpr-action';
            $attrs['value'] = $button['action'];
            $attrs['type']  = 'submit';
        }


        if( isset( $button['type'] )
            && $button['type'] === 'link' ) {

            $href = 'javascript:void(0);';

            if( isset( $button['link'] ) ) {
                $href = $button['link'];
            }

            $attrs['href'] = $href;

            if( isset( $button['target'] ) ) {
                $attrs['target'] = $button['target'];
            }

            $element = 'a';
        } else {

            $element = 'button';
        }

        $icon_html = '';

        if( isset( $button['icon'] ) && ! empty( $button['icon'] ) ) {
            $icon_html = '<i class="dashicons dashicons-' . $button['icon'] . '"></i>';
        }

        $pattern = '%s<%s %s>%s</%s>%s';
        return sprintf( $pattern,
            $element,
            $fieldType->_desc( true ),
            $fieldType->concat_attrs( $attrs ),
            $icon_html . ( isset( $field->args['label'] ) && ! empty( $button['label'] ) ? $button['label'] : $fieldType->_name() ),
            $element,
            ( isset( $field->args['message'] ) ? $button['message'] : "<span class='messate' id='{$fieldType->_id()}_message'></span>")
        );
    }
}