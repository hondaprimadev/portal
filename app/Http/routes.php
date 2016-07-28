<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
Route::group([
	'prefix'=>'upload',
	// 'middleware'=>'auth'
], function(){
	Route::get('sales', ['as'=>'upload.sales.get','uses'=>'DataController@getSales']);
	Route::post('sales', ['as'=>'upload.sales.post','uses'=>'DataController@postSales']);
	Route::get('hr', ['as'=>'upload.hr.get', 'uses'=>'DataController@getHr']);
	Route::post('hr', ['as'=>'upload.hr.post','uses'=>'DataController@postHr']);
});

Route::group([
	'prefix'=>'marketing',
	// 'middleware'=>'auth'
], function(){
	Route::get('report/branch/spv', ['as'=>'marketing.report.branch.spv.get', 'uses'=>'MarketingReportController@getSpvReport']);
	Route::get('report/branch', ['as'=>'marketing.report.branch.get', 'uses'=>'MarketingReportController@getBranchReport']);
	Route::get('report', ['as'=>'marketing.report.get', 'uses'=>'MarketingReportController@getReport']);

	Route::resource('/vehicle/sales', 'VehicleSalesController');
	Route::resource('/vehicle/stock', 'VehicleStockController');

});