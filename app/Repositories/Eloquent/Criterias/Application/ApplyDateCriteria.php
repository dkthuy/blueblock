<?php

namespace App\Repositories\Eloquent\Criterias\Application;

use Carbon\Carbon;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class ApplyDateCriteria implements CriteriaInterface
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $dateFrom = request()->get('apply_date_from');
        $dateTo = request()->get('apply_date_to');
        if (!empty($dateFrom)) {
            $dateFrom = Carbon::parse($dateFrom)
                ->tz(config('app.timezone'));
            $model = $model->where('apply_date', '>=', $dateFrom);
        }
        if (!empty($dateTo)) {
            $dateTo = Carbon::parse($dateTo)
                ->tz(config('app.timezone'));
            $model = $model->where('apply_date', '<=', $dateTo);
        }
        return $model;
    }
}
