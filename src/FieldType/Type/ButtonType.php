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
		add_action('cmb2_render_button', 'FieldType\\Type\\ButtonType::render', 10, 5);
	}

	public static function render($field, $value, $objectId, $objectType, $fieldType)
	{
		echo self::generateButton('button', $field->args, $fieldType);
	}

	public static function generateButton($type, $args, $fieldType)
	{
		$attrs = $fieldType->parse_args($type, [
			'type'    => 'button',
			'element' => (isset($field->args['element']) && !empty($args['element']) ? $args['element'] : 'button'),
			'name'    => $fieldType->_name(),
			'id'      => $fieldType->_id(),
			'class'   => 'button ' . (isset($args['button']) && !empty($args['button']) ? 'button-' . $args['button'] : ''),
		]);

		if (isset($args['action'])
			&& !empty($args['action'])) {

			$attrs['name']  = 'pmpr-action';
			$attrs['value'] = $args['action'];
			$attrs['type']  = 'submit';
		}


		if (isset($args['type'])
			&& $args['type'] === 'link') {

			$href = 'javascript:void(0);';

			if (isset($args['link'])) {
				$href = $args['link'];
			}

			$attrs['href'] = $href;

			if (isset($args['target'])) {
				$attrs['target'] = $args['target'];
			}

			$element = 'a';
		} else {

			$element = 'button';
		}

		$icon_html = '';

		if (isset($args['icon']) && !empty($args['icon'])) {
			$icon_html = '<i class="dashicons dashicons-' . $args['icon'] . '"></i>';
		}

		$pattern = '%s<%s %s>%s</%s>%s';
		$output  = sprintf($pattern,
			$fieldType->_desc(true),
			$element,
			$fieldType->concat_attrs($attrs),
			$icon_html . (isset($args['label']) && !empty($args['label']) ? $args['label'] : $args['name']),
			$element,
			(isset($args['message']) ? $args['message'] : "<span class='messate' id='{$fieldType->_id()}_message'></span>")
		);

		return $output;
	}
}