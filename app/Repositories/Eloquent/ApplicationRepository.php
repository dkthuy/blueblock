<?php

namespace App\Repositories\Eloquent;

use App\Contracts\Repositories\ApplicationRepositoryContract;
use App\Models\Application;
use App\Repositories\Eloquent\Criterias\Application\ApplyDateCriteria;
use App\Repositories\Eloquent\Criterias\Application\GiftIdCriteria;
use Prettus\Repository\Criteria\RequestCriteria;

class ApplicationRepository extends BaseRepository implements ApplicationRepositoryContract
{
    protected $fieldSearchable = [
        'apply_date',
        'apply_id',
        'gift_id',
    ];
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Application::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(ApplyDateCriteria::class));
        $this->pushCriteria(app(GiftIdCriteria::class));
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function saveApplyData(array $data) {
        return $this->model->create($data);
    }

    /**
     * @param int $userId
     *
     * @return bool
     */
    public function isSubmitted(int $userId): bool
    {
        return $this->model->where('user_id', $userId)
                           ->exists();
    }
}
