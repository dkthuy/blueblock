<?php

namespace App\Contracts\Repositories;

use Prettus\Repository\Contracts\RepositoryInterface;

interface UserRepositoryContract extends RepositoryInterface
{
    /**
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
     */
    public function register();
}
