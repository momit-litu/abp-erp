Laravel project of admin panel (any project can be developed on this codebase)

THis codebase covers auth , admin GUI, dynamic menu/module and submenu and permission based on user group

Setup:

1. run the databse/ussv2_admin.sql in mysql server
2. config the env file

development hints:

1. entry menu/submenu with route link ex: Admin Users (user/admin/admin-user-management)

2. entry different actions under the module, (diclare if the action related to any menu), ex: "Admin User Management" is an action and it is tagged with "Admin Users" menu.

3. diclare the menu/submenu name in router as 'as' and check that it must maches. ex: 'as'=>'Admin Users'

4. diclare action id  as 'action_id' in router if the action needs to pass the "permission" middleware varification. ex: 'action_id'=>4

5. create a controller and call the function of the controller and use trait HasPermission;

6. pass below code into construction
	$this->page_title = $request->route()->getName();
        $description = \Request::route()->getAction();
        $this->page_desc = isset($description['desc']) ? $description['desc'] : $this->page_title;

7. add below code pass to view 
	$data['page_title'] = $this->page_title;
	$data['module_name']= "Users";
	$data['sub_module']= "Admin Users";

8. check and pass any action permission verification is needed 
	$this->PermissionHasOrNot($admin_user_id,$action_id );

