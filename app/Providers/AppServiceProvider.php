<?php

namespace App\Providers;
use App\Models\Setting;
use App\Models\Menu;
use App\Center;
use Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //get the settings data from DB and deliver to master layout
		view()->composer('layout.master', function($view){
			$user 		= Auth::user();
			$centerName	="ABP Admin";
			$view->with('centerNamee', $centerName);
		});
		view()->composer('layout.master', function($view){
			$site_settings = Setting::first();
			$view->with('site_settings',$site_settings);
		});

		view()->composer('student-portal.layout.master', function($view){
			$user 		= Auth::user();
			$studentName	=$user->first_name;
			$view->with('studentName', $studentName);
		});
		view()->composer('student-portal.layout.master', function($view){
			$site_settings = Setting::first();
			$view->with('site_settings',$site_settings);
		});



		// get the menu list by depth 2 level
		view()->composer('layout.sidebar', function($view){
			$userId =  Auth::user()->id;

			$menus = \DB::select('SELECT  DISTINCT m.module_name , m.*
                        FROM users u
                        LEFT JOIN user_group_members gm on gm.user_id=u.id
                        left JOIN user_groups g ON gm.group_id = g.id
                        LEFT JOIN user_group_permissions p ON p.group_id=g.id
                        LEFT JOIN actions a ON a.id=p.action_id
                        LEFT JOIN menus m ON m.id=a.module_id
                        WHERE u.id='.$userId.' AND p.status=1 AND g.status=1 AND a.status=1   AND m.parent_id=0
                        GROUP BY m.module_name
                        ORDER BY serial_no');
			 $menus = json_decode(json_encode($menus),true);

			//dd($menus);
			$menus = Menu::where('parent_id',0)->where('status',1)->orderBy('serial_no')->get();
			$menu_n_submenu_array = array();
			foreach($menus as $parent_menu){
				/*$submenus = Menu::where('parent_id',$parent_menu['id'])
							->where('status',1)
							->orderBy('status','asc')->get();
				*/
				$submenus = \DB::select('SELECT m.id, m.*
								 FROM users u
								 LEFT JOIN user_group_members gm on gm.user_id=u.id
								 left JOIN user_groups g ON gm.group_id = g.id
								 LEFT JOIN user_group_permissions p ON p.group_id=g.id
								 LEFT JOIN actions a ON a.id=p.action_id
								 LEFT JOIN menus m ON m.id=a.is_menu
								 WHERE u.id='.$userId.' AND a.module_id='.$parent_menu['id'].' AND is_menu IS NOT NULL
								 AND p.status=1 AND g.status=1 AND a.status=1 AND m.status=1 AND gm.status=1
								ORDER BY m.serial_no');
				$submenus = json_decode(json_encode($submenus),true);

				if(count($submenus) ==1){
					if($submenus[0]['parent_id'] !=0){
						$parent_menu['sub_menus'] = $submenus;
					}
					$menu_n_submenu_array[] = $parent_menu;
				}
				else if(count($submenus) >0){
					$parent_menu['sub_menus'] = $submenus;
					$menu_n_submenu_array[] = $parent_menu;
				}


			}
			//dd($menu_n_submenu_array);
			$view->with('menus',$menu_n_submenu_array);
		});


    }
}


