<?php

namespace App\Supports\Traits;

trait HasPerPageRequest
{
    public function getPerPage() {
        return request('per_page');
    }
}
