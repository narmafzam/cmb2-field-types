<?php

namespace FieldType\Type;

class SizeType extends AbstractType
{
	public static function init()
	{
		self::addAction();
		self::addFilter();
	}

	public static function addAction()
	{
		parent::addAction();
		add_action('cmb2_render_size', 'FieldType\\Type\\SizeType::render', 10, 5);
	}

	public static function addFilter()
	{
		parent::addFilter();
		add_filter('cmb2_sanitize_size', 'FieldType\\Type\\SizeType::callback', 10, 2);
	}

	public static function render($field, $value, $objectId, $objectType, $fieldType)
	{

		// Make sure we specify each part of the value we need.
		$value = wp_parse_args($value, [
			'width'  => 100,
			'height' => 100,
		]); ?>

        <div class="cmb-inline">
            <ul>
                <li>
                    <label for="<?php echo $fieldType->_id('_width'); ?>"><?php _e('Max Width'); ?></label>
					<?php echo $fieldType->input([
						'name'  => $fieldType->_name('[width]'),
						'id'    => $fieldType->_id('_width'),
						'value' => $value['width'],
						'desc'  => '',
						'type'  => 'number',
						'step'  => 1,
						'min'   => 0,
						'class' => 'small-text',
					]); ?>
                </li>
                <li>
                    <label for="<?php echo $fieldType->_id('_height'); ?>"><?php _e('Max Height'); ?></label>
					<?php echo $fieldType->input([
						'name'  => $fieldType->_name('[height]'),
						'id'    => $fieldType->_id('_height'),
						'value' => $value['height'],
						'desc'  => '',
						'type'  => 'number',
						'step'  => 1,
						'min'   => 0,
						'class' => 'small-text',
					]); ?>
                </li>
            </ul>
        </div>
		<?php

		echo $fieldType->_desc(true);
	}

	public static function callback($overrideValue, $value)
	{

		if (is_array($value)) {

			foreach ($value as $key => $saved_value) {
				$value[$key] = sanitize_text_field($saved_value);
			}

			return $value;
		}

		return $overrideValue;
	}
}