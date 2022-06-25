<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\AdminRolesController;
use App\Http\Controllers\Admin\AdminPermissionsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

/*
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->get('/', function(){
        return 'Hello Hirezone Api';
    });

    $api->group(['prefix' => 'auth'] , function($api) {

        $api->post('/signup', [UserController::class, 'store']);
        $api->post('/login', [AuthController::class, 'login']);

        
        $api->group(['middleware' => 'api.auth'], function ($api) {
            $api->post('/token/refresh', [AuthController::class, 'refresh']);
            $api->post('/logout', [AuthController::class, 'logout']);
            
        });
        

    });

    $api->group(['prefix' => 'me', 'middleware' => 'api.auth'], function($api){
        $api->resource('profile', UserProfileController::class);
    });

    $api->group(['middleware' => ['role:super-admin'], 'prefix' => 'admin'], function($api){
        $api->resource('users', AdminUserController::class);
        $api->post('users/{id}/activate', [AdminUserController::class, 'activate']);
        $api->post('users/{id}/suspend', [AdminUserController::class, 'suspend']);

        $api->get('users/{id}/roles', [AdminRolesController::class, 'show']);
        $api->put('users/{id}/roles', [AdminRolesController::class, 'changeRole']);
        $api->get('users/{id}/permissions', [AdminPermissionsController::class, 'show']);


    });

    $api->group(['middleware' => ['role:employee|super-admin'], 'prefix' => 'employee'], function ($api) {
        $api->resource('categories', CategoryController::class);
        
    });
});