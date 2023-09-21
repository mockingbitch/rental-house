<?php
namespace App\Constants;

class PermissionConstant
{
    const NAME = 'Permission';

    const COLUMN_ID         = 'id';
    const COLUMN_NAME       = 'name';
    const COLUMN_GUARD_NAME = 'guard_name';

    const MSG_CREATED           = 'Permission created successfully';
    const MSG_DELETED           = 'Permission deleted successfully';
    const MSG_UPDATED           = 'Permission updated successfully';
    const MSG_CREATED_FAILED    = 'Permission created failed';
    const MSG_DELETED_FAILED    = 'Permission deleted failed';
    const MSG_UPDATED_FAILED    = 'Permission updated failed';


    const PERMISSIONS = [
        'read_post'         => 'Read Post',     //1
        'create_post'       => 'Create Post',   //2
        'update_post'       => 'Update Post',   //3
        'delete_post'       => 'Delete Post',   //4
        'read_user'         => 'Read User',     //5
        'create_user'       => 'Create User',   //6
        'update_user'       => 'Update User',   //7
        'delete_user'       => 'Delete User',   //8
        'read_role'         => 'Read Role',     //9
        'update_role'       => 'Update Role',   //10
        'create_role'       => 'Create Role',   //11
        'delete_role'       => 'Delete Role',   //12
        'read_permission'   => 'Read Permission',   //13
        'create_permission' => 'Create Permission', //14
        'update_permission' => 'Update Permission', //15
        'delete_permission' => 'Delete Permisison', //16
        'chown_permission'  => 'Chown Permission',  //17
        'chown_role'        => 'Chown Role',        //18
        'get_category'      => 'Get Category',      //19
        'create_category'   => 'Create Category',   //20
        'update_category'   => 'Update Category',   //21
        'delete_category'   => 'Delete Category',   //22
        'get_tag'           => 'Get Tag',           //23
        'create_tag'        => 'Create Tag',        //24
        'update_tag'        => 'Update Tag',        //25
        'delete_tag'        => 'Delete Tag',        //26

    ];
}