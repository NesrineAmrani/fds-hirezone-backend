<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminRolesController extends Controller
{
    public function show($id)
    {

        if (!$user = User::find($id)) {
            throw new NotFoundHttpException('User not found');
        }

        return $user->getRoleNames();
    }

    public function changeRole(Request $request, $id)
    {

        if (!$user = User::find($id)) {
            throw new NotFoundHttpException('User not found');
        }

        try {
            //syncRoles allows to change the current role
            $user->syncRoles([$request->role]);
        } catch (HttpException $th) {
            throw $th;
        }

        return response()->json(['message' => 'User roles are updated'])
                    ->setStatusCode(200);
    }
}
