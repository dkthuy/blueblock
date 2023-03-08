<?php

namespace App\Services\Question\Factories;

use App\Services\Question\QuestionFactory;

class UploadImageQuestionFactory extends QuestionFactory
{
    public function rules(): array
    {
        $options = optional($this->question)->type;

        $arrayFileValidation = [
            $this->question->is_required ? 'required' : 'nullable',
            'array',
            'max:5'
        ];
        if (!empty($options['min_files'])) {
            $arrayFileValidation[] = 'min:' . $options['min_files'];
        }
        if (!empty($options['max_files'])) {
            $arrayFileValidation[] = 'max:' . $options['max_files'];
        }
        $fileValidation = [
            'required',
        ];
        if (!empty($options['max_file_size'])) {
            $fileValidation[] = 'max:' . (int)trim($options['max_file_size']) * 1024;
        }
        if (!empty($options['min_file_size'])) {
            $fileValidation[] = 'min:' . (int)trim($options['min_file_size']) * 1024;
        }
        return [
            'answers'      => $arrayFileValidation,
            'answers.*'    => $fileValidation,
        ];
    }
}
