<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/


Route::get('/', array(
	"as" => "home",
	"uses" => "HomeController@getHomePage"	
));


Route::get("/submit", array(
	"as" => "report-submit",
	"uses" => "ReportController@getNewReportPage"	
));

Route::post("/submit", array(
	"as" => "report-submit-post",
	"uses" => "ReportController@postReport"	
));

Route::post("/submitphoto", array(
	"as" => "report-submit-photo-post",
	"uses" => "ReportController@postReportPhoto"	
));

Route::get('/test_json', 'TestDataController@getTestData');

Route::get('/test_twitter', 'TestDataController@getTwitterTest');

Route::get("/report/{id}", array(
	"as" => "report-details",
	"uses" => "ReportController@getReport"
));