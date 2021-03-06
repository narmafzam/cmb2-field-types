<?php

namespace FieldType\Type;

class DisplayType extends AbstractType
{
	public static function init()
	{
		self::addAction();
		self::addFilter();
	}

	public static function addAction()
	{
		parent::addAction();
		add_action('cmb2_render_display', 'FieldType\\Type\\DisplayType::render', 10, 5);
	}

	public static function render($field, $value, $objectId, $objectType, $fieldType)
	{
		$value = isset($field->args['value']) ? $field->args['value'] : $value;

		// Parse args
		$attrs = $fieldType->parse_args('display', [
			'class' => $field->args['classes'],
			'name'  => $fieldType->_name(),
			'id'    => $fieldType->_id(),
		]);

		echo sprintf('<div%s>%s</div>%s',
			$fieldType->concat_attrs($attrs),
			$value,
			$fieldType->_desc(true)
		);
	}
}