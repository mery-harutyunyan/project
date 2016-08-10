<?php

use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'name' => 'crud-products',
                'display_name' => 'crud-products',
                'description' => "Create, Read, Update, Delete products"
            ),
            array(
                'name' => 'view-products',
                'display_name' => 'view-products',
                'description' => "View products"
            ),

        );
        DB::table('permissions')->insert($data);
    }
}
