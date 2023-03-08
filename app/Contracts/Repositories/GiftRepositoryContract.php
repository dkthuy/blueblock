<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Prettus\Repository\Contracts\RepositoryInterface;

interface GiftRepositoryContract extends BaseRepositoryContract
{
    /**
     * @return Collection|Model[]
     */
    public function list();
}
