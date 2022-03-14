<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Mail\TestMail;
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

	
Route::get('/clear-cache', function() {
    Artisan::call('cache:clear');
	Artisan::call('route:clear');
	Artisan::call('config:clear');
	Artisan::call('view:clear');

    return "Cache is cleared";
});


Route::get('/',array('as'=>'index', 'uses' =>'StudentPortalController@index'));
Route::get('/index',array('as'=>'index', 'uses' =>'StudentPortalController@index'));
/*Route::get('/course/{id}',array('as'=>'Course Details' , 	'uses' =>'StudentPortalController@courseDetails'));
Route::get('/courses/{type}',array('as'=>'Course List' , 	'uses' =>'StudentPortalController@showCourseList'));
*/


//Route::get('/login',array('as'=>'index', 'uses' =>'AuthController@authLogin'));
Route::get('/auth',array('as'=>'Sign in', 'uses' =>'AuthController@authLogin'));
Route::get('auth/login',array('as'=>'Sign in', 'uses' =>'AuthController@authLogin'));
Route::post('auth/post/login',array('as'=>'Sign in', 'uses' =>'AuthController@authPostLogin'));
Route::get('/login',array('as'=>'login', 'uses' =>'AuthController@authLogin'));

Route::get('/payment/{id}',array('as'=>'Payment Details' , 'uses' =>'PaymentController@show'));
Route::post('/sslcommerz/success',array('as'=>'example1', 'uses' =>'StudentPortalController@sslPaymentSuccess'));
Route::post('/sslcommerz/fail',array('as'=>'example1', 'uses' =>'StudentPortalController@sslPaymentFail'));


#Login

#register
Route::get('auth/register',array('as'=>'Registration' ,  'uses' =>'AuthController@registration'));
Route::post('auth/register',array('as'=>'Registration' , 'uses' =>'AuthController@registrationSave'));
Route::get('confirm/registration/{id}',array('as'=>'Registration' ,  'uses' =>'AuthController@registrationComplete'));
Route::get('error',array('as'=>'Registration' ,  'uses' =>'AuthController@errorRequest'));

#ForgetPassword
Route::get('auth/forget/password',array('as'=>'Forgot Password' , 'uses' =>'AuthController@forgetPasswordAuthPage'));
Route::post('auth/forget/password',array('as'=>'Forgot Password' , 'uses' =>'AuthController@authForgotPasswordConfirm'));
Route::get('auth/forget/password/{user_id}/verify',array('as'=>'Forgot Password Verify' , 'uses' =>'AuthController@authSystemForgotPasswordVerification'));
Route::post('auth/forget/password/{user_id}/verify',array('as'=>'New Password Submit' , 'uses' =>'AuthController@authSystemNewPasswordPost'));

#OTP login
Route::get('auth/forget/password-otp',array('as'=>'OTP login' , 'uses' =>'AuthController@otpIndex'));
Route::post('auth/forget/password-otp',array('as'=>'OTP login' , 'uses' =>'AuthController@otpSend'));
Route::get('auth/forget/password-otp/verify',array('as'=>'OTP login Verify' , 'uses' =>'AuthController@otpVerification'));
Route::post('auth/forget/password-otp/verify',array('as'=>'OTP Submit' , 'uses' =>'AuthController@otpVerificationPost'));




Route::post('ckeditor/upload', 'CKEditorController@upload')->name('ckeditor.image-upload');

Route::get('/load-user-groups', array('as'=>'user-group' , 'uses' =>'AdminController@loadUserGroups'));
Route::post('/student-autosuggest',array('as'=>'Student Autosuggest list', 'uses' =>'StudentController@studentAutoComplete'));
Route::post('/units-autosuggest',array('as'=>'Unit Autosuggest list', 'uses' =>'UnitController@unitAutoComplete'));
Route::post('/course-autosuggest/{showType}',array('as'=>'Course Autosuggest list', 'uses' =>'CourseController@courseAutoComplete'));

Route::get('/student-course-batch-autosuggest/{id}',array('as'=>'Student Course Batch Autosuggest list', 'uses' =>'PaymentController@courseBatchList'));
Route::post('/course-batch-autosuggest',array('as'=>'Course Batch Autosuggest list', 'uses' =>'CourseController@courseBatchAutoComplete'));
Route::post('/batch-autosuggest/{course_id}',array('as'=>'Batch Autosuggest list', 'uses' =>'CourseController@batchAutoComplete'));
Route::post('/student-autosuggest/{batch_id}',array('as'=>'Student Batch Autosuggest list', 'uses' =>'StudentController@studentBatchAutoComplete'));
Route::get('/student-installment/{id}',array('as'=>'Student Installment List', 'uses' =>'PaymentController@studentInstallmentList'));

Route::post('/expense-autosuggest',array('as'=>'Expense Autosuggest list', 'uses' =>'ExpenseController@expenseAutoComplete'));
Route::get('/get-template-placeholders/{id}',array('as'=>'Template Placeholders', 'uses' =>'TemplateController@getPlaceholders'));

Route::get('/email/payment-invoice/{id}',array('as'=>'Payment Invoice Email' , 'uses' =>'PaymentController@emailInvoice'));
Route::get('/download-invoice/{id}',array('as'=>'Payment Invoice Download' , 'uses' =>'PaymentController@downloadInvoice'));



Route::post('/employement-autosuggest',array('as'=>'Employement Autosuggest list', 'uses' =>'StudentPortalController@employementAutoComplete'));
Route::post('/designation-autosuggest',array('as'=>'Designation Autosuggest list', 'uses' =>'StudentPortalController@designationAutoComplete'));

// need only authentication
Route::group(['middleware' => ['auth']], function () {
	Route::get('/theme',array('as'=>'Theme' , 			'uses' =>'AdminController@welcome'));
	Route::get('/',array('as'=>'Dashboard' , 			'uses' =>'AdminController@index'));
	Route::get('auth/logout/{email}',array('as'=>'Logout' , 'uses' =>'AuthController@authLogout'));
	Route::get('/dashboard',array('as'=>'Dashboard' , 	'uses' =>'AdminController@index'));
	Route::get('/dashboard-content/{period}',array('as'=>'Dashboard' , 	'uses' =>'ReportController@dashboardContent'));

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
	Route::get('/notification/view/{id}',array('as'=>'Notification Read', 	'uses' =>'AdminController@notificationRead'));
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
	Route::get('/course-batches/{id}',array('as'=>'Batch List' ,'action_id'=>'25', 'uses' =>'CourseController@showBatchList'));


	// Batches
	Route::get('/batch',array('as'=>'Batch', 'action_id'=>'81', 'uses' =>'BatchController@index'));
	Route::get('/batches',array('as'=>'Batch List' ,'action_id'=>'81', 'uses' =>'BatchController@showList'));
	Route::get('/batch/{id}',array('as'=>'Batch Details' ,'action_id'=>'81', 'uses' =>'BatchController@show'));
	Route::post('/batch',array('as'=>'Batch Entry' , 'action_id'=>'82', 'uses' =>'BatchController@createOrEdit'));
	Route::get('/batch/delete/{id}',array('as'=>'Batch Delete' , 'action_id'=>'84', 'uses' =>'BatchController@destroy'));

	//Batch transfer
	Route::get('/batch-transfer',array('as'=>'Batch Transfer', 'action_id'=>'118', 'uses' =>'BatchController@transferIndex'));
	Route::get('/batch-transfers',array('as'=>'Batch Transfer List' ,'action_id'=>'118', 'uses' =>'BatchController@transferShowList'));
	Route::get('/batch-transfer/{id}',array('as'=>'Batch Transfer Details' ,'action_id'=>'118', 'uses' =>'BatchController@transferShow'));
	Route::post('/batch-transfer',array('as'=>'Batch Transfer Entry' , 'action_id'=>'118', 'uses' =>'BatchController@transferCreateOrEdit'));

	Route::post('/batch-current/{course_id}/{student_id}',array('as'=>'Batch details', 'action_id'=>'118', 'uses' =>'BatchController@getCurrentBatch'));
	


	//results
	Route::get('/result',array('as'=>'Result', 'action_id'=>'119', 'uses' =>'ResultController@index'));
	Route::get('/results/{id}',array('as'=>'Result List' ,'action_id'=>'119', 'uses' =>'ResultController@showList'));
	Route::get('/result/{id}',array('as'=>'Result Details' ,'action_id'=>'119', 'uses' =>'ResultController@show'));
	Route::post('/result',array('as'=>'Result Edit' , 'action_id'=>'120', 'uses' =>'ResultController@updateResult'));
	Route::get('/result-publish/{id}',array('as'=>'Result Details' ,'action_id'=>'121', 'uses' =>'ResultController@publishResult'));



	//certificates
	Route::get('/certificate',array('as'=>'Certificate', 'action_id'=>'122', 'uses' =>'ResultController@certificateIndex'));
	Route::get('/certificates/{id}',array('as'=>'Certificate List' ,'action_id'=>'122', 'uses' =>'ResultController@certificateShowList'));
	Route::get('/certificate/{id}',array('as'=>'Certificate Details' ,'action_id'=>'122', 'uses' =>'ResultController@certificateShow'));
	Route::post('/certificate',array('as'=>'Certificate Edit' , 'action_id'=>'123', 'uses' =>'ResultController@updateCertificate'));
	Route::post('/cretificate-feedback',array('as'=>'Certificate', 'action_id'=>'123', 'uses' =>'ResultController@saveFeedback'));

	/*
	Route::get('certificate/{id}/print',array('as'=>'Certificate Print' , 'action_id'=>'125', 'uses' =>'ResultController@certificatePrint'));
	Route::get('certificate/{id}/transcript-print',array('as'=>'Certificate Print' , 'action_id'=>'125', 'uses' =>'ResultController@transcriptPrint'));
	Route::get('certificate/{id}/printed/',array('as'=>'Certificate Save' , 'action_id'=>'125', 'uses' =>'ResultController@updatePrintStatus'));
	*/
	//Payments
	Route::get('/payment',array('as'=>'Payment', 'action_id'=>'86', 'uses' =>'PaymentController@index'));
	Route::post('/payments',array('as'=>'Payment List' ,'action_id'=>'86', 'uses' =>'PaymentController@showList'));
	//Route::get('/payment/{id}',array('as'=>'Payment Details' ,'action_id'=>'86', 'uses' =>'PaymentController@show'));
	Route::post('/payment',array('as'=>'Payment Entry' , 'action_id'=>'87', 'uses' =>'PaymentController@createOrEdit'));
	Route::get('/payment/delete/{id}',array('as'=>'Payment Delete' , 'action_id'=>'89', 'uses' =>'PaymentController@destroy'));

    //books
    Route::get('/batch-book',array('as'=>'Books', 'action_id'=>'115', 'uses' =>'BatchBookController@index'));
    Route::get('/batch-books/{id}',array('as'=>'Books', 'action_id'=>'115', 'uses' =>'BatchBookController@bookList'));
	Route::get('/student-books/{id}',array('as'=>'Books', 'action_id'=>'115', 'uses' =>'BatchBookController@studenBookList'));
	Route::post('/book',array('as'=>'Books', 'action_id'=>'115', 'uses' =>'BatchBookController@saveBook'));
	Route::post('/feedback',array('as'=>'Books', 'action_id'=>'115', 'uses' =>'BatchBookController@saveFeedback'));
	Route::get('/book-send/{id}',array('as'=>'Books', 'action_id'=>'115', 'uses' =>'BatchBookController@studenBookSend'));
	

    Route::get('/email/payment-revised/{id}',array('as'=>'Revised Payment Email' , 'action_id'=>'91', 'uses' =>'PaymentController@emailRevisedPayment'));

	//Payment Schedule
	Route::get('/payment-schedule',array('as'=>'Payment Schedule', 'action_id'=>'90', 'uses' =>'PaymentController@scheduleIndex'));
	Route::get('/payment-schedules',array('as'=>'Payment Schedule List' ,'action_id'=>'90', 'uses' =>'PaymentController@scheduleShowList'));
	Route::get('/payment-schedule/{id}',array('as'=>'Payment Schedule Details' ,'action_id'=>'90', 'uses' =>'PaymentController@scheduleShow'));
	Route::post('/payment-schedule',array('as'=>'Payment Schedule Entry' , 'action_id'=>'91', 'uses' =>'PaymentController@scheduleUpdate'));
	Route::get('/payment-schedule/delete/{id}',array('as'=>'Payment Schedule Delete' , 'action_id'=>'92', 'uses' =>'PaymentController@scheduleDestroy'));


	Route::get('/revise-payment',array('as'=>'Payment Revise', 'action_id'=>'93', 'uses' =>'PaymentController@reviseIndex'));
	Route::get('/revise-payments',array('as'=>'Payment Revise List' ,'action_id'=>'93', 'uses' =>'PaymentController@reviseShowList'));
	Route::get('/revise-payments/{id}',array('as'=>'Payment Revise Details' ,'action_id'=>'93', 'uses' =>'PaymentController@reviseShow'));
	Route::post('/revise-payments',array('as'=>'Payment Revise Update' , 'action_id'=>'93', 'uses' =>'PaymentController@reviseUpdate'));


	//Notifications
	//SMS
	Route::post('/sms/due-payment',array('as'=>'Send SMS' , 'action_id'=>'94', 'uses' =>'NotificationController@sendPaymentDueSMS'));
	Route::get('/sms/send',array('as'=>'Send SMS' , 'action_id'=>'96', 'uses' =>'NotificationController@sendSMSIndex'));
	Route::post('/sms/send',array('as'=>'Send SMS' , 'action_id'=>'96', 'uses' =>'NotificationController@sendSMS'));

	// Email
	Route::get('/email/send',array('as'=>'Send Email' , 'action_id'=>'95', 'uses' =>'NotificationController@sendEmailIndex'));
	Route::post('/email/send',array('as'=>'Send Email' , 'action_id'=>'95', 'uses' =>'NotificationController@sendEmail'));
	

	//Notification Templates
	Route::get('/template',array('as'=>'Template', 'action_id'=>'117', 'uses' =>'TemplateController@index'));
	Route::get('/templates',array('as'=>'Template List' ,'action_id'=>'117', 'uses' =>'TemplateController@showList'));
	Route::get('/template/{id}',array('as'=>'Template Details' ,'action_id'=>'117', 'uses' =>'TemplateController@show'));
	Route::post('/template',array('as'=>'Template Entry' , 'action_id'=>'117', 'uses' =>'TemplateController@createOrEdit'));
	Route::get('/template/delete/{id}',array('as'=>'Template Delete' , 'action_id'=>'117', 'uses' =>'TemplateController@destroy'));
	



	//Batch student enroll
	Route::get('/batch-students/{id}',array('as'=>'Batch Students List' ,'action_id'=>'85', 'uses' =>'BatchController@studentShow'));
	Route::post('/batch-student',array('as'=>'Batch Student Entry' , 'action_id'=>'85', 'uses' =>'BatchController@enrollStudent'));
	Route::post('/batch-student/delete',array('as'=>'Batch Student Delete' , 'action_id'=>'85', 'uses' =>'BatchController@removeStudent'));
	Route::post('/batch-student/update',array('as'=>'Batch Student update' , 'action_id'=>'85', 'uses' =>'BatchController@reAddStudent'));
	Route::post('/batch-student/dropout',array('as'=>'Batch Student dropout' , 'action_id'=>'85', 'uses' =>'BatchController@dropoutStudent'));




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



	// Reports
	Route::get('course-report',array('as'=>'Course Report' , 'action_id'=>'97', 'uses' =>'ReportController@courseReport'));
	Route::post('course-report',array('as'=>'Course Report' , 'action_id'=>'97', 'uses' =>'ReportController@courseReportList'));

	Route::get('batch-report',array('as'=>'Batch Report' , 'action_id'=>'98', 'uses' =>'ReportController@batchReport'));
	Route::post('batch-report',array('as'=>'Batch Report' , 'action_id'=>'98', 'uses' =>'ReportController@batchReportList'));

	Route::get('student-report',array('as'=>'Student Report' , 'action_id'=>'99', 'uses' =>'ReportController@studentReport'));
	Route::post('student-report',array('as'=>'Student Report' , 'action_id'=>'99', 'uses' =>'ReportController@studentReportList'));

	Route::get('payment-schedule-report',array('as'=>'Payment Schedule Report' , 'action_id'=>'100', 'uses' =>'ReportController@paymentScheduleReport'));
	Route::post('payment-schedule-report',array('as'=>'Payment Schedule Report' , 'action_id'=>'100', 'uses' =>'ReportController@paymentScheduleReportList'));

	Route::get('payment-collection-report',array('as'=>'Payment Collection Report' , 'action_id'=>'101', 'uses' =>'ReportController@paymentCollectionReport'));
	Route::post('payment-collection-report',array('as'=>'Payment Collection Report' , 'action_id'=>'101', 'uses' =>'ReportController@paymentCollectionReportList'));

	Route::get('financial-report',array('as'=>'Financial Report' , 'action_id'=>'105', 'uses' =>'ReportController@financialReport'));
	Route::post('financial-report',array('as'=>'Financial Report' , 'action_id'=>'105', 'uses' =>'ReportController@financialReportList'));

	Route::get('schedule-collection-report',array('as'=>'Schedule Collection Report' , 'action_id'=>'102', 'uses' =>'ReportController@scheduleCollectionReport'));
	Route::post('schedule-collection-report',array('as'=>'Schedule Collection Report' , 'action_id'=>'102', 'uses' =>'ReportController@scheduleCollectionReportList'));

	Route::get('expense-report',array('as'=>'Expense Report' , 'action_id'=>'103', 'uses' =>'ReportController@expenseReport'));
	Route::post('expense-report',array('as'=>'Expense Report' , 'action_id'=>'103', 'uses' =>'ReportController@expenseReportList'));

	Route::get('expense-income',array('as'=>'Expense Vs Income Report' , 'action_id'=>'104', 'uses' =>'ReportController@expenseIncome'));
	Route::post('expense-income',array('as'=>'Expense Vs Income Report' , 'action_id'=>'104', 'uses' =>'ReportController@expenseIncomeList'));

});


Route::group(['prefix' => 'portal', 'middleware' => ['prevent-back-history']], function () {
	Route::get('/course/{id}',array('as'=>'Course Details' , 	'uses' =>'StudentPortalController@courseDetails'));
	Route::get('/courses/{type}',array('as'=>'Course List' , 	'uses' =>'StudentPortalController@showCourseList'));
	Route::post('/student-info',array('as'=>'Student Update','uses' =>'StudentPortalController@studentEdit'));
	Route::get('terms',array('as'=>'Terms Condition', 'uses' =>'StudentPortalController@terms'));
	//Route::get('/courses/{type}',array('as'=>'Course List' , 	'uses' =>'StudentPortalController@showCourseList'));

	Route::group(['middleware' => ['auth','prevent-back-history']], function () {

		Route::get('/',array('as'=>'Dashboard' , 			'uses' =>'StudentPortalController@index'));
		Route::get('/dashboard',array('as'=>'Dashboard' , 	'uses' =>'StudentPortalController@index'));
		Route::get('auth/logout/{email}',array('as'=>'Logout' , 'uses' =>'AuthController@authLogout'));
		//Route::get('/course/{id}',array('as'=>'Course Details' , 	'uses' =>'StudentPortalController@courseDetails'));
		//Route::get('/courses/{type}',array('as'=>'Course List' , 	'uses' =>'StudentPortalController@showCourseList'));
		Route::get('/courses/my/{type}',array('as'=>'My Course List' , 	'uses' =>'StudentPortalController@showMyCourseList'));

		//Payment
		Route::post('/sslcommerz/pay-via-ajax',array('as'=>'example1', 'uses' =>'SslCommerzPaymentController@payViaAjax'));


		Route::get('/payments/{type}',array('as'=>'Payment List' , 	'uses' =>'StudentPortalController@showPaymentList'));

		Route::post('/payment/revise',array('as'=>'Revise Payment' , 	'uses' =>'StudentPortalController@savePaymentRevise'));
		Route::get('/checkout/{id}',array('as'=>'Payment Checkout', 'uses' =>'StudentPortalController@checkoutShow'));

		Route::get('/student-info',array('as'=>'Student Details' , 'uses' =>'StudentPortalController@studentShow'));
		Route::post('/student-enroll',array('as'=>'Student Enroll','uses' =>'StudentPortalController@studentEnroll'));

	});
});

// bkash payment gateway
Route::group(['middleware' => ['auth']], function () {
    // Payment Routes for bKash
    Route::post('bkash/get-token', 'BkashController@getToken')->name('bkash-get-token');
    Route::post('bkash/create-payment', 'BkashController@createPayment')->name('bkash-create-payment');
    Route::post('bkash/execute-payment', 'BkashController@executePayment')->name('bkash-execute-payment');
    Route::get('bkash/query-payment', 'BkashController@queryPayment')->name('bkash-query-payment');
    Route::post('bkash/success', 'BkashController@bkashSuccess')->name('bkash-success');

    // Refund Routes for bKash
    Route::get('bkash/refund', 'BkashRefundController@index')->name('bkash-refund');
    Route::post('bkash/refund', 'BkashRefundController@refund')->name('bkash-refund');
});

?>
