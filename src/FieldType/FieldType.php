<?php

namespace FieldType;

use FieldType\Type\AdvanceSelectType;
use FieldType\Type\ButtonType;
use FieldType\Type\DisplayType;
use FieldType\Type\HtmlType;
use FieldType\Type\MultiButtonType;
use FieldType\Type\SizeType;
use FieldType\Type\SliderType;

class FieldType
{
    public static function init()
    {
        AdvanceSelectType::init();
        MultiButtonType::init();
        DisplayType::init();
        ButtonType::init();
        SliderType::init();
        HtmlType::init();
        SizeType::init();
    }
}