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
		add_action('cmb2_render_slider', 'FieldType\\Type\\SliderType::render', 10, 5);
	}

	public static function render($field, $value, $objectId, $objectType, $fieldType)
	{
		// Parse args
		$attrs = $fieldType->parse_args('slider', [
			'type'  => 'slider',
			'name'  => $fieldType->_name(),
			'id'    => $fieldType->_id() . '_' . 'container',
			'class' => 'slider-type',
		]);

		if (isset($field->args['container-attr'])) {
			$attrs = self::generateAttrs($fieldType, $field->args['container-attr'], $attrs);
		} else {
			$attrs = self::generateAttrs($fieldType, [], $attrs);
		}

		$defaultClass = 'slider-image';
		if (isset($field->args['image-attr'])) {

			$imageAttrs = self::generateAttrs($fieldType, $field->args['image-attr'], ['class' => $defaultClass]);
		} else {

			$imageAttrs = self::generateAttrs($fieldType, [], ['class' => $defaultClass]);
		}

		$images = '';
		if (isset($field->args['images'])) {

			foreach ($field->args['images'] as $id => $image) {

				if (!empty($image)) {

					$images .= "<img data-flickity-lazyload-src=\"{$image}\" data-id=\"{$id}\" {$imageAttrs}/>";
				}
			}
		}

		echo sprintf("<div %s>%s</div><input type=\"hidden\" name='{$fieldType->_name()}' id=\"{$fieldType->_id()}\" class='slider-image'/>",
			$attrs,
			$images
		);
	}

	public static function array2json($array)
	{
		return json_encode($array);
	}

	public static function generateAttrs($fieldType, $attrs, $defaults)
	{
		$targetAttr = [];
		foreach ($defaults as $key => $default) {

			if (isset($attrs[$key])) {

				$targetAttr[$key] = $default . ' ' . $targetAttr[$key];
			} else {

				$targetAttr[$key] = $default;
			}
		}
		return $fieldType->concat_attrs($targetAttr);
	}
}