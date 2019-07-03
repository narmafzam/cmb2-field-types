<?php

namespace FieldType\Type;

class AdvanceSelectType extends AbstractType
{
    public static function init()
    {
        self::addAction();
        self::addFilter();
    }

    public static function addAction()
    {
        parent::addAction();
        add_action( 'cmb2_render_advanced_select', 'FieldType\\Type\\AdvanceSelectType::render', 10, 5 );
    }

    public static function addFilter()
    {
        parent::addFilter();
        add_filter( 'cmb2_sanitize_advanced_select', 'FieldType\\Type\\AdvanceSelectType::callback', 10, 2 );
    }

    public static function render( $field, $escapedValue, $objectId, $objectType, $fieldTypeObject ) {

        // Parse args
        $attrs = $fieldTypeObject->parse_args( 'select', array(
            'class'   => 'cmb2_select',
            'name'    => $fieldTypeObject->_name(),
            'id'      => $fieldTypeObject->_id(),
        ) );

        // Support for multiple
        if( $field->args['multiple'] ) {

            $attrs['name'] = $attrs['name'] . '[]';
            $attrs['multiple'] = 'true';

        }

        // Parse options
        $options = '';

        foreach ( $field->options() as $value => $option ) {

            if( is_array( $option ) ) {

                // Options group
                $options .= '<optgroup label="'. $value .'">';

                foreach ( $option as $key => $label ) {
                    $selected = ( is_array( $escapedValue ) && in_array( $key, $escapedValue ) ) || $escapedValue === $key;

                    $options .= sprintf( '<option value="%s"%s>%s</option>',
                        $key,
                        $selected ? 'selected="selected"' : '',
                        $label
                    );
                }

                $options .= '</optgroup>';

            } else {

                $selected = ( is_array( $escapedValue ) && in_array( $value, $escapedValue ) ) || $escapedValue === $value;

                //Single option
                $options .= sprintf( '<option value="%s"%s>%s</option>',
                    $value,
                    $selected ? 'selected="selected"' : '',
                    $option
                );

            }
        }

        echo sprintf( '<select%s>%s</select>%s',
            $fieldTypeObject->concat_attrs( $attrs ),
            $options,
            $fieldTypeObject->_desc( true )
        );

    }

    public static function callback( $overrideValue, $value ) {

        // Sanitize multiple value
        if ( is_array( $value ) ) {

            foreach ( $value as $key => $saved_value ) {

                $value[$key] = sanitize_text_field( $saved_value );

            }

            return $value;

        }

        return sanitize_text_field( $value );

    }
}