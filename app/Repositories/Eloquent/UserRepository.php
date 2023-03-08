<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\UserRepositoryContract;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class UserRepository extends BaseRepository implements UserRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Builder
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function register() {
        $data = [];
        return $this->makeModel()->create($data);
    }
}
