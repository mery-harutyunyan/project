<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
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
                'name' => 'user',
                'display_name' => 'user',
                'description' => "project's user"
            ),
            array(
                'name' => 'admin',
                'display_name' => 'admin',
                'description' => "project's admin"
            ),

        );
        DB::table('roles')->insert($data);
    }
}
