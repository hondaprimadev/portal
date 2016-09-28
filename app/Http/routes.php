<?php
Route::get('login', 'Auth\AuthController@showLoginForm');
Route::post('login', 'Auth\AuthController@login');
Route::get('logout', 'Auth\AuthController@logout');

Route::group([
	'middleware'=>'auth',
], function(){
	Route::get('/','DashboardController@index');
	Route::delete('profile/delete/{file}',['as'=>'profile.delete','uses'=>'UserPictureController@deleteProfile']);
	Route::get('/profile/{token}',['as'=>'profile.index','uses'=>'DashboardController@getProfile']);
	Route::patch('/profile/{token}',['as'=>'profile.store','uses'=>'DashboardController@postProfile']);
});

// Group user
Route::group([
	'prefix'=>'admin/user',
	'middleware'=>'auth',
], function(){
	Route::get('role/setting', ['as'=>'admin.user.role.setting.get','uses'=>'RoleController@setPermission']);
	Route::post('role/setting', ['as'=>'admin.user.role.setting.post','uses'=>'RoleController@postPermission']);

	Route::post('user/delete', ['as'=>'admin.user.delete', 'uses'=>'UserController@destroy']);
	Route::post('permission/delete', ['as'=>'admin.user.permission.delete','uses'=>'PermissionController@delete']);
	Route::post('role/delete', ['as'=>'admin.user.role.delete','uses'=>'RoleController@delete']);

	Route::resource('/permission','PermissionController');
	Route::resource('/role','RoleController');
	Route::resource('/user','UserController');
});

// Group Upload
Route::group([
	'prefix'=>'upload',
	'middleware'=>'auth'
], function(){
	Route::get('sales', ['as'=>'upload.sales.get','uses'=>'DataController@getSales']);
	Route::post('sales', ['as'=>'upload.sales.post','uses'=>'DataController@postSales']);
	Route::get('hr', ['as'=>'upload.hr.get', 'uses'=>'DataController@getHr']);
	Route::post('hr', ['as'=>'upload.hr.post','uses'=>'DataController@postHr']);
});

// Group marketing
Route::group([
	'prefix'=>'marketing',
	'middleware'=>'auth'
], function(){
	Route::get('report/sales', ['as'=>'marketing.report.sales.get','uses'=>'MarketingReportController@getSalesIdReport']);
	Route::get('report/branch/sales', ['as'=>'marketing.report.branch.sales.get', 'uses'=>'MarketingReportController@getSalesReport']);
	Route::get('report/branch/spv', ['as'=>'marketing.report.branch.spv.get', 'uses'=>'MarketingReportController@getSpvReport']);
	Route::get('report/branch', ['as'=>'marketing.report.branch.get', 'uses'=>'MarketingReportController@getBranchReport']);
	Route::get('report', ['as'=>'marketing.report.get', 'uses'=>'MarketingReportController@getReport']);
	Route::get('team', ['as'=>'marketing.team.index','uses'=>'MarketingReportController@getTeam']);
	Route::post('team', ['as'=>'marketing.team.post','uses'=>'MarketingReportController@postTeam']);

	Route::post('/vehicle/sales/delete', 'VehicleSalesController@delete');
	
	Route::resource('/vehicle/sales', 'VehicleSalesController');
	Route::resource('/vehicle/stock', 'VehicleStockController');

});

// Group HRD
Route::group([
	'prefix'=>'hrd',
	'middleware'=>'auth'
], function(){
	Route::post('user/create', ['as'=>'hrd.user.create', 'uses'=>'HrdEmployeeController@addUser']);
	//delete employee
	Route::post('employee/delete', ['as'=>'hrd.employee.delete', 'uses'=>'HrdEmployeeController@delete']);
	Route::post('department/delete', ['as'=>'hrd.department.delete', 'uses'=>'HrdDepartmentController@delete']);
	Route::post('position/delete', ['as'=>'hrd.position.delete', 'uses'=>'HrdPositionController@delete']);
	
	Route::delete('employee/profile/delete/{file}',['as'=>'hrd.employee.profile.delete','uses'=>'UserPictureController@deleteProfile']);
	Route::post('employee/profile',['as'=>'hrd.employee.profile.post', 'uses'=>'UserPictureController@postPicture']);
	Route::get('employee/profile/{file}',['as'=>'hrd.employee.profile.get', 'uses'=>'UserPictureController@getPicture']);
	Route::get('employee/profile/tmp/{file}',['as'=>'hrd.employee.profile.tmp.get', 'uses'=>'UserPictureController@getTmpPicture']);
	// etc
	Route::get('employee/nik', ['as'=>'hrd.employee.get.id','uses'=>'HrdEmployeeController@getNik']);

	Route::resource('employee', 'HrdEmployeeController');
	Route::resource('department', 'HrdDepartmentController');
	Route::resource('position', 'HrdPositionController');

});

// Group CRM
Route::group([
	'middleware'=>'auth',
], function(){
	Route::post('/crm/delete', 'CrmController@delete');
	Route::resource('/crm', 'CrmController');
});

Route::group([
	'prefix'=>'api',
	'middleware' => 'jwt.auth',
], function(){
	Route::resource('agenda','Api\MarketingAgendaController');
});

Route::group(['prefix' => 'api'], function()
{
    Route::resource('authenticate', 'Auth\AuthenticateJWTController', ['only' => ['index']]);
    Route::post('authenticate', 'Auth\AuthenticateJWTController@authenticate');
    Route::get('authenticate/user', 'Auth\AuthenticateJWTController@getAuthenticatedUser');
});