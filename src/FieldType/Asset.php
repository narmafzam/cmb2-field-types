<?php

namespace FieldType;

use Generic\Asset as BaseClass;

class Asset extends BaseClass
{
	const FIELD_TYPE_SCRIPT = 'field-type-script';
	const FIELD_TYPE_STYLE = 'field-type-style';

	public static function init()
	{
		self::addAction();
	}

	public static function addAction()
	{
		add_action('cmb2_footer_enqueue', 'FieldType\\Asset::enqueue');
	}

	public static function enqueue()
	{
		wp_enqueue_script(
			self::FIELD_TYPE_SCRIPT,
			Utility::getAssetUrl('/js/field.js', __DIR__),
			['jquery']
		);
		wp_enqueue_style(
			self::FIELD_TYPE_STYLE,
			function_exists('get_locale') && get_locale() === 'fa_IR'
				? Utility::getAssetUrl('/css/field-rtl.css', __DIR__)
				: Utility::getAssetUrl('/css/field.css', __DIR__)
		);
	}
}