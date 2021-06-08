<?php

use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */

    public function run()
    {
		$menus = [
            [
				'id' => '1',
                'module_name' => 'User',
				'menu_title' => 'Users',
				'menu_url' => '',
				'parent_id' => '0',
				'serial_no' => '1',
				'menu_icon_class' => 'clip-user-plus',
				'status' => '1',
            ],
            [
				'id' => '2',
                'module_name' => 'Users',
				'menu_title' => 'Admin Users',
				'menu_url' => 'user/admin/admin-user-management',
				'parent_id' => '1',
				'serial_no' => '1',
				'menu_icon_class' => NULL,
				'status' => '1',
            ],
            [
				'id' => '3',
                'module_name' => 'Users',
				'menu_title' => 'Client Users',
				'menu_url' => 'user/admin/client-user-management',
				'parent_id' => '1',
				'serial_no' => '2',
				'menu_icon_class' => NULL,
				'status' => '1',
            ],
			[
				'id' => '4',
                'module_name' => 'Cpanel',
				'menu_title' => 'Control Panel',
				'menu_url' => '',
				'parent_id' => '0',
				'serial_no' => '9',
				'menu_icon_class' => 'clip-settings',
				'status' => '1',
            ],
			[
				'id' => '5',
                'module_name' => 'Cpanel',
				'menu_title' => 'General Setting',
				'menu_url' => 'cp/general/general-setting',
				'parent_id' => '4',
				'serial_no' => '1',
				'menu_icon_class' => NULL,
				'status' => '1',
            ],
			[
				'id' => '5',
                'module_name' => 'Cpanel',
				'menu_title' => 'Menus/Moduls',
				'menu_url' => 'cp/module/manage-module',
				'parent_id' => '4',
				'serial_no' => '2',
				'menu_icon_class' => NULL,
				'status' => '1',
            ],
			[
				'id' => '5',
                'module_name' => 'Cpanel',
				'menu_title' => 'Web Actions',
				'menu_url' => 'cp/web-action/web-action-management',
				'parent_id' => '4',
				'serial_no' => '3',
				'menu_icon_class' => NULL,
				'status' => '1',
            ],
        ];

		foreach ($menus as $menu) {
			 \DB::table('menus')->insert([
				'module_name' => $menu['module_name'],
				'menu_title' => $menu['menu_title'],
				'menu_url' => $menu['menu_url'],
				'parent_id' => $menu['parent_id'],
				'serial_no' => $menu['serial_no'],
				'menu_icon_class' => $menu['menu_icon_class'],
				'status' => $menu['status'],
			]);
        }	
    }
}