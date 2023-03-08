<?php

namespace App\Contracts\Repositories;

interface ApplicationRepositoryContract extends BaseRepositoryContract
{
    public function saveApplyData(array $data);

    public function isSubmitted(int $userId): bool;
}
