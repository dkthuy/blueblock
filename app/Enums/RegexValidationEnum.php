<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class RegexValidationEnum extends Enum
{
    public const HALF_WIDTH_EXCEPT0_REGEX = '/^[1-9]{1}[0-9]{0,}$/u';
    public const HALF_WIDTH_SERIAL_REGEX = '/^[A-Z0-9!-\'*-.^-`~:?@]+$/u';
    public const HALF_WIDTH_NUMBER_REGEX = '/^[0-9]+$/u';
    public const HALF_WIDTH_WORD_NUMBER_REGEX = '/^[a-zA-Z0-9]+$/u';
    public const FULL_WIDTH_REGEX = '/^[ａ-ｚＡ-Ｚ一-龠々-〇ぁ-んァ-ヶ]+$/u';
    public const PASSWORD_REGEX = '/^(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[a-zA-Z0-9]*$/u';
    public const PASSWORD2_REGEX = '/^(?=.{8,})(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*+_-])[a-zA-Z0-9!@#$%^&*+_-]*$/u';
    public const EXCEPT_CODE_CHARACTERS_REGEX = '/^[^\;\<\=\>\/\[\]\{\|\}\\\\]+$/u';
    public const KATAKANA_WORD_FULL_WIDTH = '/^[ァ-ヶー・]+$/u';
    public const ZIPCODE = '/^[0-9]{3}-[0-9]{4}$/u';
    public const CUSTOM_DATE = '/^(19|20)((\d{2}((0[13-9]|1[0-2])(?=[0-2][1-9]|[1-3]0)|(0[13578]|1[02])(?=31)|02(?=[0-2][1-8]|[12]0|[01]9)))|(([02468][048]|[13579][26])02(?=[0-2][1-9]|[12]0)))\d{2}$/u';
}
