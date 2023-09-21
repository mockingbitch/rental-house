<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;
use App\Constants\Constant;
use App\Constants\RoleConstant;
use App\Constants\PermissionConstant;
use DB;

class SetupController extends Controller
{

    public function setUp()
    {
        \Artisan::call('db:seed --class=SqlFileSeeder');
        \Artisan::call('migrate');

        $role               = Role::create([RoleConstant::COLUMN_NAME => RoleConstant::ROLE_SUPER_ADMIN]);
        $roleHouseHolder    = Role::create([RoleConstant::COLUMN_NAME => RoleConstant::ROLE_HOUSE_HOLDER]);
        $roleGuest          = Role::create([RoleConstant::COLUMN_NAME => RoleConstant::ROLE_GUEST]);

        $user = User::create([
            'name' => env('USER_NAME'),
            'email' => env('USER_EMAIL'),
            'password' => bcrypt(env('USER_PASSWORD'))
        ]);

        $permissions = [];

        foreach (PermissionConstant::PERMISSIONS as $permission) :
            $permissions[] = Permission::create([PermissionConstant::COLUMN_NAME => $permission]);
        endforeach;

        $role->syncPermissions($permissions);
        $user->syncRoles($role);

        return response()->json([
            'message'       => Constant::MSG_SETUP_SUCCESS,
            'errorCode'     => Constant::ERR_CODE_OK
        ], Response::HTTP_CREATED);
    }
}
