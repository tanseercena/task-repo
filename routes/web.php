<?php

use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Role;
use App\User;

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

Route::get('/create-roles', function() {
  Role::create(['name' => 'merchant']);
  Role::create(['name' => 'employee']);
});

Route::get('/', function () {
    $collaborators = User::role("employee")->get();
    return view('welcome', ['collaborators' => $collaborators]);
})->name("start");

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['prefix' => 'merchant', 'middleware' => ['auth','role:merchant']], function(){
  Route::get('/services','MerchantController@services')->name('services');
  Route::get('/add-service','MerchantController@addService')->name('add.service');
  Route::post('/save-service','MerchantController@saveService')->name('save.service');
  Route::get("/service/{service}/assign-employee",'MerchantController@assignEmployee')->name("assign.employee");
  Route::post("/service/{service}/assign-employees",'MerchantController@assignEmployees')->name("assign.employees");
  Route::get("/service/{service}/appointments",'MerchantController@appointments')->name("service.appointments");

  Route::get("/employees","MerchantController@employees")->name('employees');
  Route::get("/add-employee","MerchantController@addEmployee")->name('add.employee');
  Route::post('/save-employee','MerchantController@saveEmployee')->name('save.employee');
});

Route::group(['prefix' => 'employee', 'middleware' => ['auth','role:employee']], function(){
  Route::get('/services','MerchantController@empServices')->name('emp.services');
    Route::get("/service/{service}/appointments",'MerchantController@empAppointments')->name("emp.service.appointments");
});

Route::group(['prefix'=>'appointment'], function() {
  Route::post("/book","AppointmentController@book")->name("book.appointment");
  Route::get('/book/{user_id}/step2',"AppointmentController@step2")->name('appointment.step2');
  Route::get('/book/{user_id}/{service}/step3',"AppointmentController@step3")->name('appointment.step3');
  Route::get('/book/{user_id}/{service}/{date}/step4',"AppointmentController@step4")->name('appointment.step4');
  Route::get("/booking/{id}/finish","AppointmentController@finish")->name("finish");
});
