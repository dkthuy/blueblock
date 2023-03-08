<?php

namespace App\Contracts\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

interface BaseRepositoryContract extends RepositoryInterface
{
    public function paginateOrAll($perPage = null, $columns = ['*']);
}
