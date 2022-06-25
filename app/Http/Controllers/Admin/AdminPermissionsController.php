<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Transformers\UserPermissionTransformer;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminPermissionsController extends Controller
{
    public function show($id)
    {
        if (!$user = User::find($id)) {
            throw new NotFoundHttpException('User not found');
        }

        return $this->response->collection($user->getAllPermissions(), new UserPermissionTransformer);
    }
}
