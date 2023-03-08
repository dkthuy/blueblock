<?php

namespace App\Transformers;

use App\Models\Admin;
use Flugg\Responder\Transformers\Transformer;

class AdminTransformer extends Transformer
{
    /**
     * List of available relations.
     *
     * @var string[]
     */
    protected $relations = [];

    /**
     * List of autoloaded default relations.
     *
     * @var array
     */
    protected $load = [];

    /**
     * Transform the model.
     *
     * @param Admin $admin
     * @return array
     */
    public function transform(Admin $admin): array
    {
        $role = $admin->roles()->first();
        return [
            'id' => $admin->id,
            'login_id' => $admin->login_id,
            'name' => $admin->name,
            'role' => $role->name ?? null,
            'status' => $admin->status,
            'created_at' => $admin->created_at,
            'updated_at' => $admin->updated_at,
        ];
    }
}
