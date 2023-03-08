<?php

namespace App\Contracts\Actions;

interface LoginActionContract
{
    public function __invoke(array $data);
}
