<?php

namespace FieldType\Type;

class SliderType extends AbstractType
{
    public static function init()
    {
        self::addAction();
        self::addFilter();
    }

    public static function addAction()
    {
        parent::addAction();
        add_action( 'cmb2_render_slider', 'FieldType\\Type\\SliderType::render', 10, 5 );
    }

    public static function render( $field, $value, $objectId, $objectType, $fieldType )
    {
        // Parse args
        $attrs        = $fieldType->parse_args( 'slider', array(
            'type'  => 'slider',
            'name'  => $fieldType->_name(),
            'id'    => $fieldType->_id() . '_' . 'container',
            'class' => 'slider-type',
        ));

        if ( isset( $field->args['container-attr'] )) {
            $attrs   = self::generateAttrs($fieldType, $field->args['container-attr'], $attrs);
        } else {
            $attrs   = self::generateAttrs($fieldType, [], $attrs);
        }

//        $defaultClass = 'image-container';
//        if ( isset( $field->args['image-container-attr'] )) {
//            $imageContainerAttr   = self::generateAttrs($fieldType, $field->args['image-container-attr'], ['class' => $defaultClass]);
//        } else {
//            $imageContainerAttr   = self::generateAttrs($fieldType, [], ['class' => $defaultClass]);
//        }

        $defaultClass = 'slider-image';
        if ( isset( $field->args['image-attr'] )) {
            $imageAttrs   = self::generateAttrs($fieldType, $field->args['image-attr'], ['class' => $defaultClass]);
        } else {
            $imageAttrs   = self::generateAttrs($fieldType, [], ['class' => $defaultClass]);
        }

        $images     = '';
        if ( isset( $field->args['images'] ) ) {
            foreach ( $field->args['images'] as $alt => $image ) {
                if ( ! empty( $image ) ) {
                    $images .= "<img src=\"{$image}\" alt=\"...\" {$imageAttrs}/>";
                }
            }
        }

        echo sprintf( "<div %s>%s<input type=\"hidden\" id=\"{$fieldType->_id()}\"/></div>",
            $attrs,
            $images
        );
    }

    public static function array2json( $array )
    {
        return json_encode( $array );
    }

    public static function generateAttrs($fieldType, $attrs, $defaults)
    {
        $targetAttr = [];
        foreach ($defaults as $key => $default) {
            if ( isset( $attrs[$key] ) ) {
                $targetAttr[$key] = $default . ' ' . $targetAttr[$key];
            } else {
                $targetAttr[$key] = $default;
            }
        }
        return $fieldType->concat_attrs( $targetAttr );
    }
}