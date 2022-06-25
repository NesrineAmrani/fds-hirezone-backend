<?php

namespace App\Transformers;

use League\Fractal\TransformerAbstract;
use Spatie\Permission\Contracts\Permission;

class UserPermissionTransformer extends TransformerAbstract 
{
    public function transform(Permission $permission)
    {
        return [
            'id' => (int) $permission->id,
            'name' => $permission->name,
        ];
    }
}

