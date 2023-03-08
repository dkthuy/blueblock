<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\AdminRepositoryContract;
use App\Models\Admin;
use Prettus\Repository\Criteria\RequestCriteria;

class AdminRepository extends BaseRepository implements AdminRepositoryContract
{
    protected $fieldSearchable = [
        'login_id',
        'name',
        'status',
        'roles.name',
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Admin::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
