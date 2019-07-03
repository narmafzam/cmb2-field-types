<?php

namespace FieldType\Type;

class HtmlType extends AbstractType
{
    public static function init()
    {
        self::addAction();
        self::addFilter();
    }

    public static function addAction()
    {
        parent::addAction();
        add_action( 'cmb2_render_html', 'FieldType\\HtmlType::render', 10, 5 );
    }

    public static function render($field, $value, $objectId, $objectType, $fieldType)
    {
        // Parse args
        $attrs = $fieldType->parse_args( 'html', array(
            'id'      => $fieldType->_id(),
        ) );

        if( isset( $field->args['content_cb'] ) && ! empty( $field->args['content_cb'] ) ) {
            ob_start();
            call_user_func_array( $field->args['content_cb'], array( $field, $objectId, $objectType ) );
            $field->args['content'] = ob_get_clean();
        }

        echo sprintf( '<div %s>%s</div>',
            $fieldType->concat_attrs( $attrs ),
            ( isset( $field->args['content'] ) && ! empty( $field->args['content'] ) ? $field->args['content'] : '' )
        );
    }
}