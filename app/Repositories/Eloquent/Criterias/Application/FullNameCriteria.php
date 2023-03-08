<?php

namespace App\Repositories\Eloquent\Criterias\Application;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class FullNameCriteria implements CriteriaInterface
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $fullname = request()->get('full_name');
        if (!empty($fullname)) {
            $fullname = '%' . $fullname . '%';
            $model = $model->where(function ($query) use ($fullname) {
                return $query->whereRaw("concat(first_name, ' ', last_name) like ? ", [$fullname])
                             ->orWhereRaw("concat(furigana_first_name, ' ', furigana_last_name) like ? ", [$fullname]);
            });
        }

        return $model;
    }
}
