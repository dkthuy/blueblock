<?php

namespace App\Repositories\Eloquent\Criterias\Application;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

class GiftIdCriteria implements CriteriaInterface
{

    /**
     * @throws \Psr\Container\ContainerExceptionInterface
     * @throws \Psr\Container\NotFoundExceptionInterface
     */
    public function apply($model, RepositoryInterface $repository)
    {
        $giftId = request()->get('gift_id');
        if (!empty($giftId)) {
            $model = $model->where(function ($query) use ($giftId) {
                return $query->where('gift_id', $giftId);
            });
        }

        return $model;
    }
}
