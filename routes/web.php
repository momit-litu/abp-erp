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

Route::get('/load-user-groups', array('as'=>'user-group' , 'uses' =>'AdminController@loadUserGroups'));
Route::post('/units-autosuggest',array('as'=>'Unit Autosuggest list', 'uses' =>'UnitController@unitAutoComplete'));
Route::post('/qualifications-autosuggest/{showType}',array('as'=>'Qualification Autosuggest list', 'uses' =>'QualificationController@qualificationAutoComplete'));
Route::post('/learner-autosuggest',array('as'=>'Learner Autosuggest list', 'uses' =>'LearnerController@learnerAutoComplete'));

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
	Route::get('/web-action/get-module-name',array('as'=>'Web Action Management' , 'uses' =>'SettingController@getModuleName'));
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
	Route::get('/web-action/action-lists',array('as'=>'Web Action List', 'action_id'=>'5' , 'uses' =>'SettingController@webActionList'));
	Route::post('/web-action/web-action-entry',array('as'=>'Web Action Entry', 'action_id'=>'6', 'uses' =>'SettingController@webActionEntry'));
	Route::get('/web-action/edit/{id}',array('as'=>'Web Action Edit', 'action_id'=>'7', 'uses' =>'SettingController@web_action_edit'));

	//Menus/ Modules
	Route::get('cp/module/manage-module',array('as'=>'Manage Module' , 'action_id'=>'8', 'uses' =>'SettingController@moduleManagement'));
	Route::get('/module/menu-list',array('as'=>'Menu List' ,'action_id'=>'8', 'uses' =>'SettingController@ajaxMenuList'));
	Route::post('/module/module-entry/',array('as'=>'Module Entry' , 'action_id'=>'9', 'uses' =>'SettingController@moduleEntry'));
	Route::get('/module/edit/{id}',array('as'=>'Module Edit' , 'action_id'=>'10', 'uses' =>'SettingController@moduleEdit'));
	Route::get('/module/delete/{id}',array('as'=>'Module Edit' , 'action_id'=>'11', 'uses' =>'SettingController@moduleDelete'));

	//General Setting
	Route::get('settings/general/general-setting',array('as'=>'General Setting Management', 'action_id'=>'12', 'uses' =>'SettingController@generalSetting'));
	Route::post('/general/setting-update',array('as'=>'General Setting Update', 'action_id'=>'15', 'uses' =>'SettingController@generalSettingUpdate'));


	//Admin User Group
	Route::get('settings/admin/admin-group-management',array('as'=>'Admin User Groups Management', 'action_id'=>'16', 'uses' =>'AdminController@admin_user_groups'));
	Route::get('/admin/admin-group-list',array('as'=>'Admin Groups List' ,   'action_id'=>'16','uses' =>'AdminController@admin_groups_list'));
	Route::post('/admin/admin-group-entry',array('as'=>'Admin Groups Entry', 'action_id'=>'17', 'uses' =>'AdminController@admin_groups_entry_or_update'));
	Route::get('/admin/admin-group-edit/{id}',array('as'=>'Admin Groups Edit', 'action_id'=>'18', 'uses' =>'AdminController@admin_group_edit'));
	Route::get('/admin/admin-group-delete/{id}',array('as'=>'Admin Groups Delete', 'action_id'=>'19', 'uses' =>'AdminController@admin_group_delete'));
	//Permission
	Route::post('/admin/permission-action-entry-update',array('as'=>'Permission Entry', 'action_id'=>'20', 'uses' =>'AdminController@permission_action_entry_update'));

	// qualification units
	Route::get('/unit',array('as'=>'Units', 'action_id'=>'21', 'uses' =>'UnitController@index'));
	Route::get('/units',array('as'=>'Unit List' ,'action_id'=>'21', 'uses' =>'UnitController@showList'));
	Route::get('/unit/{id}',array('as'=>'Unit Details' ,'action_id'=>'21', 'uses' =>'UnitController@show'));
	Route::post('/unit',array('as'=>'Unit Entry' , 'action_id'=>'22', 'uses' =>'UnitController@createOrEdit'));
	Route::get('/unit/delete/{id}',array('as'=>'Unit Delete' , 'action_id'=>'24', 'uses' =>'UnitController@destroy'));

	// qualification 
	Route::get('/qualification',array('as'=>'Qualifications', 'action_id'=>'25', 'uses' =>'QualificationController@index'));
	Route::get('/qualifications',array('as'=>'Qualification List' ,'action_id'=>'25', 'uses' =>'QualificationController@showList'));
	Route::get('/qualification/{id}',array('as'=>'Qualification Details' ,'action_id'=>'47', 'uses' =>'QualificationController@show'));
	Route::post('/qualification',array('as'=>'Qualification Entry' , 'action_id'=>'26', 'uses' =>'QualificationController@createOrEdit'));
	Route::get('/qualification/delete/{id}',array('as'=>'Qualification Delete' , 'action_id'=>'28', 'uses' =>'QualificationController@destroy'));

	// Center 
	Route::get('/center',array('as'=>'Centers', 'action_id'=>'29', 'uses' =>'CenterController@index'));
	Route::get('/centers',array('as'=>'Center List' ,'action_id'=>'29', 'uses' =>'CenterController@showList'));
	Route::get('/center/{id}',array('as'=>'Center Details' ,'action_id'=>'29', 'uses' =>'CenterController@show'));
	Route::post('/center',array('as'=>'Center Entry' , 'action_id'=>'30', 'uses' =>'CenterController@createOrEdit'));
	Route::get('/center/delete/{id}',array('as'=>'Center Delete' , 'action_id'=>'32', 'uses' =>'CenterController@destroy'));


	//Learners
	Route::get('learner',array('as'=>'Learner' , 'action_id'=>'38', 'uses' =>'LearnerController@index'));
	Route::get('/learners',array('as'=>'Learner List' ,  'action_id'=>'38','uses' =>'LearnerController@showList'));
	Route::get('/learner/{id}',array('as'=>'Learner View' , 'action_id'=>'38', 'uses' =>'LearnerController@show'));
	Route::post('/learner',array('as'=>'Learner Entry', 'action_id'=>'39', 'uses' =>'LearnerController@createOrEdit'));
	Route::get('/learner/delete/{id}',array('as'=>'Learner Delete', 'action_id'=>'41', 'uses' =>'LearnerController@destroy'));

	//Registrations
	Route::get('registration',array('as'=>'Registration' , 'action_id'=>'43', 'uses' =>'RegistrationController@index'));
	Route::get('/registrations',array('as'=>'Registration List' ,  'action_id'=>'43','uses' =>'RegistrationController@showList'));
	Route::get('/registration/{id}',array('as'=>'Registration View' , 'action_id'=>'43', 'uses' =>'RegistrationController@show'));
	Route::post('/registration',array('as'=>'Registration Entry', 'action_id'=>'45', 'uses' =>'RegistrationController@createOrEdit'));
	Route::get('/registration/delete/{id}',array('as'=>'Registration Delete', 'action_id'=>'46', 'uses' =>'RegistrationController@destroy'));
	
	//Transcript
	Route::get('transcript/{id}',array('as'=>'Transcript' , 'action_id'=>'48', 'uses' =>'RegistrationController@transcript'));
	Route::post('/transcript',array('as'=>'Transcript Save', 'action_id'=>'50', 'uses' =>'RegistrationController@transcriptSave'));
	Route::get('/claim-certificate/{id}',array('as'=>'Claim Cirtificate', 'action_id'=>'51', 'uses' =>'RegistrationController@claimCirtificate'));
	
	Route::get('certificate',array('as'=>'Cirtificate' , 'action_id'=>'52', 'uses' =>'RegistrationController@certificateIndex'));
	Route::get('/certificates',array('as'=>'Cirtificate List' ,  'action_id'=>'43','uses' =>'RegistrationController@showCertificateList'));
	Route::get('certificate/{id}',array('as'=>'Cirtificate VIew' , 'action_id'=>'43', 'uses' =>'RegistrationController@certificateShow'));
	Route::get('certificate/{id}/print',array('as'=>'Cirtificate Print' , 'action_id'=>'63', 'uses' =>'RegistrationController@certificatePrint'));
	Route::get('certificate/{id}/transcript-print',array('as'=>'Cirtificate Print' , 'action_id'=>'63', 'uses' =>'RegistrationController@transcriptPrint'));
	
	Route::post('certificate',array('as'=>'Cirtificate Save' , 'action_id'=>'53', 'uses' =>'RegistrationController@certificateSave'));
});

