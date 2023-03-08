<?php

namespace App\Enums;

use BenSampo\Enum\Enum;

final class QuestionTypeEnum extends Enum
{
    const MULTIPLE_CHOICE = 'multiple-choice';
    const SINGLE_CHOICE = 'single-choice';
    const UPLOAD_IMAGES = 'upload-images';
    const INPUT = 'input';
    const TEXTAREA = 'textarea';
}
