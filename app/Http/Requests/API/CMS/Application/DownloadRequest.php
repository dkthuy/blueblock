<?php

namespace App\Http\Requests\API\CMS\Application;

use App\Http\Requests\API\BaseRequest;

class DownloadRequest extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'per_page' => 'required|integer',
            'page'     => 'required|integer'
        ];
    }
}
