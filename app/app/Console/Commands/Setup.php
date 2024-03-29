<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Constants\RoleConstant;
use App\Constants\PermissionConstant;
use Illuminate\Support\Facades\Schema;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'To migrate database configuration';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        if (!Schema::hasTable('districts')) :
            \Artisan::call('db:seed --class=SqlFileSeeder');
        endif;
        \Artisan::call('migrate');

//        $roleSupAdmin = Role::create([
//            RoleConstant::COLUMN_NAME
//            => RoleConstant::ROLE_SUPER_ADMIN
//        ]);
//        $roleAdmin = Role::create([
//            RoleConstant::COLUMN_NAME
//            => RoleConstant::ROLE_ADMIN
//        ]);
//        $roleLessor = Role::create([
//            RoleConstant::COLUMN_NAME
//            => RoleConstant::ROLE_LESSOR
//        ]);
//        $roleLessee = Role::create([
//            RoleConstant::COLUMN_NAME
//            => RoleConstant::ROLE_LESSEE
//        ]);

        User::create([
            'name' => env('USER_NAME'),
            'email' => env('USER_EMAIL'),
            'password' => bcrypt(env('USER_PASSWORD')),
            'role' => 'ADMIN',
        ]);

//        $permissions = [];
//        foreach (PermissionConstant::PERMISSIONS as $permission) :
//            $permissions[] = Permission::create([
//                PermissionConstant::COLUMN_NAME => $permission
//            ]);
//        endforeach;
//
//        $roleSupAdmin->syncPermissions($permissions);
//        $user->syncRoles($roleSupAdmin);

        return Command::SUCCESS;
    }
}
