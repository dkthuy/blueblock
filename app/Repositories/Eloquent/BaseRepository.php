<?php

namespace App\Repositories\Eloquent;

abstract class BaseRepository extends \Prettus\Repository\Eloquent\BaseRepository implements \App\Contracts\Repositories\BaseRepositoryContract
{
    public function paginateOrAll($perPage = null, $columns = ['*'])
    {
        if (!empty($perPage)) {
            return $this->paginate($perPage, $columns);
        }
        return $this->all($columns);
    }
}
