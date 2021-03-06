<?php

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

Route::auth();
Route::get('document', 'DocumentController@index');
Route::get('rekap', 'DocumentController@rekap');
// Route::group(['middleware' => 'authorization:working_schedule'], function(){

Route::group(['middleware' => 'auth'], function(){
	Route::get('', 'HomeController@index');

	Route::group(['middleware' => 'authorize:status_0'], function(){
		Route::get('approval_report', 'ApprovalController@report');

		Route::get('approval_0_regta', 'ApprovalRegtaController@index');
		Route::post('approval_0_regta', 'ApprovalRegtaController@search');
		Route::get('approval_0_regta/{nik}', 'ApprovalRegtaController@list');
		Route::get('approval_0_regta/{id}/approve', 'ApprovalRegtaController@approve');
		// Route::resources(['approval_0_regta' => 'ApprovalRegtaController']);

		Route::get('approval_0_regtt', 'ApprovalRegttController@index');
		Route::post('approval_0_regtt', 'ApprovalRegttController@search');
		Route::get('approval_0_regtt/{nik}', 'ApprovalRegttController@list');
		Route::get('approval_0_regtt/{id}/approve', 'ApprovalRegttController@approve');
		// Route::resources(['approval_0_regtt' => 'ApprovalRegttController']);
	});

	Route::group(['middleware' => 'authorize:status_1'], function(){
		Route::get('approval_1_regta', 'ApprovalRegtaStatus1Controller@index');
		Route::post('approval_1_regta', 'ApprovalRegtaStatus1Controller@search');
		Route::get('approval_1_regta/{nik}', 'ApprovalRegtaStatus1Controller@list');
		Route::get('approval_1_regta/{id}/approve', 'ApprovalRegtaStatus1Controller@approve');
		// Route::resources(['approval_1_regta' => 'ApprovalRegtaStatus1Controller']);

		Route::get('approval_1_regtt', 'ApprovalRegttStatus1Controller@index');
		Route::post('approval_1_regtt', 'ApprovalRegttStatus1Controller@search');
		Route::get('approval_1_regtt/{nik}', 'ApprovalRegttStatus1Controller@list');
		Route::get('approval_1_regtt/{id}/approve', 'ApprovalRegttStatus1Controller@approve');
		// Route::resources(['approval_1_regtt' => 'ApprovalRegttStatus1Controller']);
	});
	
	Route::group(['middleware' => 'authorize:status_2'], function(){

		Route::get('approval_2_regta', 'ApprovalRegtaStatus2Controller@index');
		Route::post('approval_2_regta', 'ApprovalRegtaStatus2Controller@search');
		Route::get('approval_2_regta/{nik}', 'ApprovalRegtaStatus2Controller@list');
		Route::get('approval_2_regta/{id}/approve', 'ApprovalRegtaStatus2Controller@approve');
		// Route::resources(['approval_2_regta' => 'ApprovalRegtaStatus2Controller']);

		Route::get('approval_2_regtt', 'ApprovalRegttStatus2Controller@index');
		Route::post('approval_2_regtt', 'ApprovalRegttStatus2Controller@search');
		Route::get('approval_2_regtt/{nik}', 'ApprovalRegttStatus2Controller@list');
		Route::get('approval_2_regtt/{id}/approve', 'ApprovalRegttStatus2Controller@approve');
		// Route::resources(['approval_2_regtt' => 'ApprovalRegttStatus2Controller']);
	});

	Route::group(['middleware' => 'authorize:data_personal'], function(){
		Route::get('biodata/upload_pendidikan', 'BiodataController@uploadPendidikan');
		Route::get('biodata/upload_pengalaman', 'BiodataController@uploadPengalaman');
		Route::get('biodata/upload_organisasi', 'BiodataController@uploadOrganisasi');
		Route::get('biodata/upload_kursus', 'BiodataController@uploadKursus');
		Route::get('biodata/upload_ska', 'BiodataController@uploadSKA');
		Route::get('biodata/upload_skt', 'BiodataController@uploadSKT');
		Route::resources(['biodata' => 'BiodataController']);
		Route::get('biodata/{id}/upload', 'BiodataController@upload');
	});

	Route::group(['middleware' => 'authorize:user'], function(){
		Route::resources([
		    'users' => 'UserController',
		]);
		Route::resources([
			'user_role' => 'UserRoleController',
		]);
	});
	
	Route::group(['middleware' => 'authorize:verify'], function(){
		// Route::get('document', 'DocumentController@index');
		// Route::get('rekap', 'DocumentController@rekap');
		
		Route::get('vva/ska', 'PengajuanNaikStatusController@ska');
		Route::get('vva/skt', 'PengajuanNaikStatusController@skt');
	});
	
	Route::group(['middleware' => 'authorize:rekap'], function(){
		Route::get('rekaprpl', 'RekapRPLController@index');
	});
	
	Route::get('pdf', 'PDFController@index');
	
});