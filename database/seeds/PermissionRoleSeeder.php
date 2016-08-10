<?php

use Illuminate\Database\Seeder;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $adminRole = DB::table('roles')
            ->select('id')
            ->where('name', 'admin')
            ->first()
            ->id;
        $userRole = DB::table('roles')
            ->select('id')
            ->where('name', 'user')
            ->first()
            ->id;



        $crudProductsPermission = DB::table('permissions')
            ->select('id')
            ->where('name', 'crud-products')
            ->first()
            ->id;

        $viewProductsPermission = DB::table('permissions')
            ->select('id')
            ->where('name', 'view-products')
            ->first()
            ->id;


        $data = array(
            array(
                'permission_id' => $crudProductsPermission,
                'role_id' => $adminRole,
            ),
            array(
                'permission_id' => $viewProductsPermission,
                'role_id' => $userRole,
            ),

        );
        DB::table('permission_role')->insert($data);
    }
}
