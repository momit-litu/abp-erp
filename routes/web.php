<?php

use Illuminate\Support\Facades\Route;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

#Login

Route::get('/',array('as'=>'login', 'uses' =>'AuthController@authLogin'));
Route::get('/login',array('as'=>'login', 'uses' =>'AuthController@authLogin'));
Route::get('/auth',array('as'=>'Sign in', 'uses' =>'AuthController@authLogin'));
Route::get('auth/login',array('as'=>'Sign in', 'uses' =>'AuthController@authLogin'));
Route::post('auth/post/login',array('as'=>'Sign in', 'uses' =>'AuthController@authPostLogin'));

#ForgetPassword
Route::get('auth/forget/password',array('as'=>'Forgot Password' , 'uses' =>'AuthController@forgetPasswordAuthPage'));
Route::post('auth/forget/password',array('as'=>'Forgot Password' , 'uses' =>'AuthController@authForgotPasswordConfirm'));
Route::get('auth/forget/password/{user_id}/verify',array('as'=>'Forgot Password Verify' , 'uses' =>'AuthController@authSystemForgotPasswordVerification'));
Route::post('auth/forget/password/{user_id}/verify',array('as'=>'New Password Submit' , 'uses' =>'AuthController@authSystemNewPasswordPost'));


Route::post('ckeditor/upload', 'CKEditorController@upload')->name('ckeditor.image-upload');

Route::get('/load-user-groups', array('as'=>'user-group' , 'uses' =>'AdminController@loadUserGroups'));
Route::post('/units-autosuggest',array('as'=>'Unit Autosuggest list', 'uses' =>'UnitController@unitAutoComplete'));
Route::post('/courses-autosuggest/{showType}',array('as'=>'Course Autosuggest list', 'uses' =>'CourseController@qualificationAutoComplete'));

// need only authentication
Route::group(['middleware' => ['auth']], function () {
	Route::get('/theme',array('as'=>'Theme' , 			'uses' =>'AdminController@welcome'));
	Route::get('/',array('as'=>'Dashboard' , 			'uses' =>'AdminController@index'));
    Route::get('auth/logout/{email}',array('as'=>'Logout' , 'uses' =>'AuthController@authLogout'));
	Route::get('/dashboard',array('as'=>'Dashboard' , 	'uses' =>'AdminController@index'));

	//my Profile
	Route::get('/profile',array('as'=>'My Profile', 		'uses' =>'AdminController@profileIndex'));
	Route::get('/profile/my-profile-info',array('as'=>'Get My Profile Info', 	'uses' =>'AdminController@profileInfo'));
	Route::post('/profile/my-profile-update',array('as'=>'Update My Profile Info', 'uses' =>'AdminController@updateProfile'));
	Route::post('/profile/password-update',array('as'=>'Update My Profile Info', 'uses' =>'AdminController@updatePassword'));
	//Menus/ Modules
	Route::get('/module/get-parent-menu',array('as'=>'Parent Menu List' ,'uses' =>'SettingController@getParentMenu'));
	Route::get('/web-action/get-module-name',array('as'=>'Actions' , 'uses' =>'SettingController@getModuleName'));
	Route::get('/admin/load-actions-for-group-permission/{id}',array('as'=>'Load Actions', 'uses' =>'AdminController@load_actions_for_group_permission'));

	Route::get('/notification',array('as'=>'All Notifications', 		'uses' =>'AdminController@profileIndex'));
	Route::get('/notifications',array('as'=>'All Notifications', 		'uses' =>'AdminController@ajaxNotificationList'));
	Route::get('/notifications/{page}',array('as'=>'Notifications', 	'uses' =>'AdminController@notificationHome'));
	Route::get('/notification/view',array('as'=>'Notification Read', 	'uses' =>'AdminController@notificationRead'));
	Route::get('/update-notification',array('as'=>'Read Notifications', 'uses' =>'AdminController@updateNotification'));

});

// need  authentication and permission to access the action/action-lists
// you have to define the action no from DB
Route::group(['middleware' => ['auth','permission'] ], function () {
	//Admin User
	Route::get('user/admin/admin-user-management',array('as'=>'Users' , 'action_id'=>'1', 'uses' =>'AdminController@adminUserManagement'));
	Route::get('/admin/ajax/admin-list',array('as'=>'User List' ,  'action_id'=>'1','uses' =>'AdminController@ajaxAdminList'));
	Route::get('/admin/admin-view/{id}',array('as'=>'View' , 'action_id'=>'1', 'uses' =>'AdminController@adminUserView'));
	Route::post('/admin/admin-user-entry',array('as'=>'User Entry', 'action_id'=>'2', 'uses' =>'AdminController@ajaxAdminEntry'));
	Route::get('/admin/edit/{id}',array('as'=>'User Edit', 'action_id'=>'3', 'uses' =>'AdminController@adminUserEdit'));
	Route::get('/admin/delete/{id}',array('as'=>'User Delete', 'action_id'=>'4', 'uses' =>'AdminController@adminDestroy'));

	// Actions
	Route::get('cp/web-action/web-action-management',array('as'=>'Web Action Management', 'action_id'=>'5', 'uses' =>'SettingController@webActionManagement'));
	Route::get('/web-action/action-lists',array('as'=>'Actions', 'action_id'=>'5' , 'uses' =>'SettingController@webActionList'));
	Route::post('/web-action/web-action-entry',array('as'=>'Web Action Entry', 'action_id'=>'6', 'uses' =>'SettingController@webActionEntry'));
	Route::get('/web-action/edit/{id}',array('as'=>'Web Action Edit', 'action_id'=>'7', 'uses' =>'SettingController@web_action_edit'));

	//Menus/ Modules
	Route::get('cp/module/manage-module',array('as'=>'Modules' , 'action_id'=>'8', 'uses' =>'SettingController@moduleManagement'));
	Route::get('/module/menu-list',array('as'=>'Menu List' ,'action_id'=>'8', 'uses' =>'SettingController@ajaxMenuList'));
	Route::post('/module/module-entry/',array('as'=>'Module Entry' , 'action_id'=>'9', 'uses' =>'SettingController@moduleEntry'));
	Route::get('/module/edit/{id}',array('as'=>'Module Edit' , 'action_id'=>'10', 'uses' =>'SettingController@moduleEdit'));
	Route::get('/module/delete/{id}',array('as'=>'Module Edit' , 'action_id'=>'11', 'uses' =>'SettingController@moduleDelete'));

	//General Setting
	Route::get('settings/general/general-setting',array('as'=>'General Setting', 'action_id'=>'12', 'uses' =>'SettingController@generalSetting'));
	Route::post('/general/setting-update',array('as'=>'General Setting Update', 'action_id'=>'15', 'uses' =>'SettingController@generalSettingUpdate'));

	//Admin User Group
	Route::get('settings/admin/admin-group-management',array('as'=>'User Groups', 'action_id'=>'16', 'uses' =>'AdminController@admin_user_groups'));
	Route::get('/admin/admin-group-list',array('as'=>'Admin Groups List' ,   'action_id'=>'16','uses' =>'AdminController@admin_groups_list'));
	Route::post('/admin/admin-group-entry',array('as'=>'Admin Groups Entry', 'action_id'=>'17', 'uses' =>'AdminController@admin_groups_entry_or_update'));
	Route::get('/admin/admin-group-edit/{id}',array('as'=>'Admin Groups Edit', 'action_id'=>'18', 'uses' =>'AdminController@admin_group_edit'));
	Route::get('/admin/admin-group-delete/{id}',array('as'=>'Admin Groups Delete', 'action_id'=>'19', 'uses' =>'AdminController@admin_group_delete'));
	//Permission
	Route::post('/admin/permission-action-entry-update',array('as'=>'Permission Entry', 'action_id'=>'20', 'uses' =>'AdminController@permission_action_entry_update'));


	// Course units
	Route::get('/unit',array('as'=>'Units', 'action_id'=>'21', 'uses' =>'UnitController@index'));
	Route::get('/units',array('as'=>'Unit List' ,'action_id'=>'21', 'uses' =>'UnitController@showList'));
	Route::get('/unit/{id}',array('as'=>'Unit Details' ,'action_id'=>'21', 'uses' =>'UnitController@show'));
	Route::post('/unit',array('as'=>'Unit Entry' , 'action_id'=>'22', 'uses' =>'UnitController@createOrEdit'));
	Route::get('/unit/delete/{id}',array('as'=>'Unit Delete' , 'action_id'=>'24', 'uses' =>'UnitController@destroy'));


	// Courses 
	Route::get('/course',array('as'=>'Courses', 'action_id'=>'25', 'uses' =>'CourseController@index'));
	Route::get('/courses',array('as'=>'Course List' ,'action_id'=>'25', 'uses' =>'CourseController@showList'));
	Route::get('/course/{id}',array('as'=>'Course Details' ,'action_id'=>'25', 'uses' =>'CourseController@show'));
	Route::post('/course',array('as'=>'Course Entry' , 'action_id'=>'26', 'uses' =>'CourseController@createOrEdit'));
	Route::get('/course/delete/{id}',array('as'=>'Course Delete' , 'action_id'=>'28', 'uses' =>'CourseController@destroy'));



	//students
	Route::get('student',array('as'=>'Student' , 'action_id'=>'38', 'uses' =>'StudentController@index'));
	Route::get('/students',array('as'=>'Student List' ,  'action_id'=>'38','uses' =>'StudentController@showList'));
	Route::get('/student/{id}',array('as'=>'Student View' , 'action_id'=>'38', 'uses' =>'StudentController@show'));
	Route::post('/student',array('as'=>'Student Entry', 'action_id'=>'39', 'uses' =>'StudentController@createOrEdit'));
	Route::get('/student/delete/{id}',array('as'=>'Student Delete', 'action_id'=>'41', 'uses' =>'StudentController@destroy'));

	// expense
	Route::get('expense/expense-category',array('as'=>'Expense Category' , 'action_id'=>'66', 'uses' =>'ExpenseController@categoryIndex'));
	Route::get('/expense/expense-category-list',array('as'=>'Expense Category List' ,'action_id'=>'66', 'uses' =>'ExpenseController@ajaxExpenseCategoryList'));
	Route::get('/expense/expense-category-list/{id}',array('as'=>'Expense Category List' ,'action_id'=>'66', 'uses' =>'ExpenseController@show'));
	Route::post('/expense/expense-category',array('as'=>'Expense Category Entry' ,'action_id'=>'67', 'uses' =>'ExpenseController@createOrEdit'));
	Route::get('/expense/expense-category-delete/{id}',array('as'=>'Expense Category Delete' ,'action_id'=>'69', 'uses' =>'ExpenseController@destroy'));
	// Expense Head
    Route::get('expense/expense-head',array('as'=>'Expense Head' , 'action_id'=>'73', 'uses' =>'ExpenseController@expenseHeadIndex'));
    Route::get('/expense/expense-head-list',array('as'=>'Expense Head List' ,'action_id'=>'73', 'uses' =>'ExpenseController@ajaxExpenseHeadList'));
    Route::get('/expense/expense-head-list/{id}',array('as'=>'Expense Head List' ,'action_id'=>'75', 'uses' =>'ExpenseController@showHead'));
    Route::post('/expense/expense-head',array('as'=>'Expense Head Entry' ,'action_id'=>'73', 'uses' =>'ExpenseController@ExpensHeadcreateOrEdit'));
    Route::get('/expense/expense-head-delete/{id}',array('as'=>'Expense Head Delete' ,'action_id'=>'76', 'uses' =>'ExpenseController@destroyHead'));
    // Expense Detail
    Route::get('expense/expense',array('as'=>'Expenses' , 'action_id'=>'77', 'uses' =>'ExpenseController@expenseDetailIndex'));
    Route::get('/expense/expense-detail-list',array('as'=>'Expense List' ,'action_id'=>'77', 'uses' =>'ExpenseController@ajaxExpenseDetailList'));
    Route::get('/expense/expense-detail-list/{id}',array('as'=>'Expense List' ,'action_id'=>'77', 'uses' =>'ExpenseController@showDetail'));
    Route::post('/expense/expense-detail',array('as'=>'Expense Entry' ,'action_id'=>'77', 'uses' =>'ExpenseController@ExpensDetailcreateOrEdit'));
    Route::get('/expense/expense-detail-delete/{id}',array('as'=>'Expense Delete' ,'action_id'=>'80', 'uses' =>'ExpenseController@destroyDetail'));
    Route::get('/expense/download/{id}',array('as'=>'Expense List' ,'action_id'=>'77', 'uses' =>'ExpenseController@getDownload'));
});

