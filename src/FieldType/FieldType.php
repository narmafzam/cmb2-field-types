<?php

namespace FieldType;

use FieldType\Type\AdvanceSelectType;
use FieldType\Type\ButtonType;
use FieldType\Type\DisplayType;
use FieldType\Type\HtmlType;
use FieldType\Type\MultiButtonType;
use FieldType\Type\SizeType;

class FieldType
{
    public static function init()
    {
        AdvanceSelectType::init();
        ButtonType::init();
        MultiButtonType::init();
        DisplayType::init();
        HtmlType::init();
        SizeType::init();
    }
}