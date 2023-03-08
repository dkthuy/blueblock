<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\GiftRepositoryContract;
use App\Models\Gift;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class GiftRepository extends BaseRepository implements GiftRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Gift::class;
    }

    /**
     * @return Collection|Model[]
     */
    public function list()
    {
        return $this->model->all();
    }
}
