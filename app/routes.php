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

Route::get('/', 'BaseController@index');

Route::get('users/login', 'UsersController@login');

Route::resource('users', 'UsersController');

Route::post('users/signin', 'UsersController@signin');

Route::resource('dwellers', 'DwellersController');

Route::resource('expenses', 'ExpensesController');

Route::resource('months', 'MonthsController');

Route::get('month/{date}/cast', 'MoneyController@cast');

Route::get('month/{date}/rebase', 'MoneyController@rebaseCalc');

Route::post('month/generateMonths', 'MonthsController@generateMonths');

Route::post('month/deleteMonths', 'MonthsController@deleteMonths');

Route::get('expense/{id}/{date}/pay', 'MoneyController@pay');

Route::get('dweller/{id}/history', 'MoneyController@history');

Route::post('expense/parcialPay/{idExpense}/{idDweller}/{credit}', 'MoneyController@parcialPay');

Route::post('expense/reversePayment/{idDweller}/{date}', 'MoneyController@reversePayment');

Route::resource('categories', 'CategoriesController');

Route::resource('categories', 'CategoriesController');

Route::get('reports', 'ReportsController@index');

Route::get('report/mural', 'ReportsController@mural');

Route::post('report/mural', 'ReportsController@muralFilter');

Route::get('report/debtsDwellers', 'ReportsController@debtsDwellers');

Route::post('report/debtsDwellers', 'ReportsController@debtsDwellersFilter');

Route::get('report/openExpenses', 'ReportsController@openExpenses');

Route::post('report/openExpenses', 'ReportsController@openExpensesFilter');

Route::resource('apartments', 'ApartmentsController');

Route::resource('parameters', 'ParametersController');