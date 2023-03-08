<?php

namespace App\Repositories\Eloquent;

use App\Models\Question;
use App\Contracts\Repositories\QuestionRepositoryContract;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

class QuestionRepository extends BaseRepository implements QuestionRepositoryContract
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Question::class;
    }



    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function list() {
        return $this->model->orderBy('order', 'asc')->get();
    }
}
