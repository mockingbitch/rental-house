<?php
namespace App\Constants;

class RoleConstant
{
    const NAME = 'Role';

    const ROLE_SUPER_ADMIN  = 'Super Admin';
    const ROLE_HOUSE_HOLDER = 'House holder';
    const ROLE_GUEST        = 'Guest';

    const COLUMN_ID         = 'id';
    const COLUMN_NAME       = 'name';
    const COLUMN_GUARD_NAME = 'guard_name';

    const MSG_CREATED = 'Role created successfully';
    const MSG_DELETED = 'Role deleted successfully';
    const MSG_UPDATED = 'Role updated successfully';
    const MSG_CREATED_FAILED = 'Role created failed';
    const MSG_DELETED_FAILED = 'Role deleted failed';
    const MSG_UPDATED_FAILED = 'Role updated failed';
}