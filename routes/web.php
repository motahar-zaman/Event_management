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

Route::get('/', function () {
    if(Auth::user()){
        return view('home');
    } else {
        return redirect()->to('login');
    }
});

Auth::routes();



Route::get('/logout', function(){
    Auth::logout();
    return redirect()->to('login');
})->name('logout');

Route::group(['middleware' => 'auth'], function () {
    Route::get('/home', 'HomeController@index')->name('home');
    // Route::get('/phones', 'HomeController@index')->name('phone-list');

    //clients
    Route::get('/clients', 'ClientsController@index')->name('clients-list');
    Route::post('/add-clients', 'ClientsController@addClients')->name('add-clients');
    Route::post('/status-change', 'ClientsController@status')->name('clients-status-change');

    //projects
    Route::get('/projects', 'ProjectsController@index')->name('projects-list');
    Route::post('/add-projects', 'ProjectsController@addProjects')->name('add-projects');
    Route::post('/projects-status-change', 'ProjectsController@status')->name('projects-status-change');

    //client-payments
    Route::get('/client-payments', 'ClientsPaymentsController@index')->name('client-payments-list');
    Route::get('/get-projects', 'ClientsPaymentsController@getProjects')->name('get-projects');
    Route::post('/add-clients-payments', 'ClientsPaymentsController@addClientsPayments')->name('add-clients-payments');
    Route::get('/edit-clients-payments', 'ClientsPaymentsController@editClientsPayments')->name('edit-clients-payments');
    Route::get('/delete-clients-payments/{id}', 'ClientsPaymentsController@deleteClientsPayments')->name('delete-clients-payments');

    //expenses
    Route::get('/expenses', 'ExpensesController@index')->name('expenses-list');
    Route::post('/add-expenses', 'ExpensesController@addExpenses')->name('add-expenses');
    Route::get('/expenses-edit', 'ExpensesController@editExpenses')->name('edit-expenses');
    Route::get('/expenses-delete/{id}', 'ExpensesController@deleteExpenses')->name('expenses-delete');

    //Email Credentials
    Route::get('/email', 'EmailController@index')->name('client-email');
    Route::post('/add-email', 'EmailController@addEmail')->name('add-email');
    Route::post('/edit-email', 'EmailController@editEmail')->name('edit-email');

    //Server Credentials
    Route::get('/server', 'ServerController@index')->name('client-server');
    Route::post('/add-server', 'ServerController@addServer')->name('add-server');
    Route::post('/edit-server', 'ServerController@editServer')->name('edit-server');

    //Domain Credentials
    Route::get('/domain', 'DomainController@index')->name('client-domain');
    Route::post('/add-domain', 'DomainController@addDomain')->name('add-domain');
    Route::post('/edit-domain', 'DomainController@editDomain')->name('edit-domain');

    //Third party site Credentials
    Route::get('/site', 'SiteController@index')->name('client-site');
    Route::post('/add-site', 'SiteController@addSite')->name('add-site');
    Route::post('/edit-site', 'SiteController@editSite')->name('edit-site');
});
