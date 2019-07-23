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
        add_action('cmb2_render_button', 'FieldType\\Type\\SliderType::render', 10, 5);
    }

    public static function render($field, $value, $objectId, $objectType, $fieldType)
    {
        // Parse args
        $attrs = $fieldType->parse_args('slider', array(
            'type' => 'slider',
            'name' => $fieldType->_name(),
            'id' => $fieldType->_id(),
            'data-flickity' => self::array2json($field->args['flickity'])
        ));
        $imageAttrs = [];
        $defaultClass = 'img-fluid rounded ';
        if (isset($field->args['image-attr'])
            && is_array($field->args['image-attr'])) {
            $imageAttrs = $field->args['image-attr'];
            if (isset($imageAttrs['class'])) {
                $imageAttrs['class'] = $defaultClass . $imageAttrs['class'];
            } else {
                $imageAttrs['class'] = $defaultClass;
            }
            $imageAttrs = $fieldType->concat_attrs($imageAttrs);
        }
        $images = '';
        if (isset($field->args['images'])) {
            foreach ($field->args['images'] as $alt => $image) {
                if (!empty($image)) {
                    $images = "<div class=\"w-100\"><img src=\"{$image}\" alt=\"{$alt}\" {$imageAttrs}\"></div>";
                }
            }
        }

        echo sprintf('<div %s>%s</div>',
            $fieldType->concat_attrs($attrs),
            $images
        );
    }

    public static function array2json($array)
    {
        return json_encode($array);
    }

}