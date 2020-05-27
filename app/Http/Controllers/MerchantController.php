<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Service;
use Session;
use App\User;
use App\Appointment;
use Illuminate\Support\Facades\Hash;

class MerchantController extends Controller
{
    public function services() {
      $user_id = auth()->id();
      $services = Service::where("user_id",$user_id)->get();

      return view('merchant.services', ['services' => $services]);
    }

    public function empServices() {
      $user_id = auth()->id();
      $user = User::find($user_id);
      $services = $user->services;

      return view('merchant.services', ['services' => $services]);
    }

    public function addService() {
      return view("merchant.services_add");
    }

    public function saveService(Request $request){
      $this->validate($request, [
        'name' => 'required',
        'timing_from' => 'required',
        'timing_to' => 'required',
        'people' => 'required',
      ]);

      $service = new Service();
      $service->name = $request->name;
      $service->timing_from = $request->timing_from;
      $service->timing_to = $request->timing_to;
      $service->people = $request->people;
      $service->user_id = auth()->id();

      if($service->save()){
        Session::flash('message', 'Service Successfully Added!');
        Session::flash('alert-class', 'alert-success');
      }else{
        Session::flash('message', 'Error while adding service!');
        Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route("services");
    }

    public function employees() {
      $merchant_id = auth()->id();
      $employees = User::role('employee')->where("merchant_id",$merchant_id)->get();
      return view('merchant.employees',['employees' => $employees]);
    }

    public function addEmployee() {
      return view("merchant.employee_add");
    }

    public function saveEmployee(Request $request) {
      $this->validate($request, [
        'name' => 'required',
        'email' => 'required',
        'password' => 'required',
      ]);

      $user = new User();
      $user->name = $request->name;
      $user->email = $request->email;
      $user->merchant_id = auth()->id();
      $user->password = Hash::make($request->password);

      if($user->save()){
        $user->assignRole('employee');
        Session::flash('message', 'Employee Successfully Added!');
        Session::flash('alert-class', 'alert-success');
      }else{
        Session::flash('message', 'Error while adding employee!');
        Session::flash('alert-class', 'alert-danger');
      }

      return redirect()->route("employees");
    }

    public function assignEmployee(Service $service) {
      $merchant_id = auth()->id();
      $employees = User::role('employee')->where("merchant_id",$merchant_id)->get();
      $assigned_employees = $service->users;
      return view("merchant.assign_employee",
      ['service' => $service, 'employees' => $employees, 'assigned_employees' => $assigned_employees]);
    }

    public function assignEmployees(Request $request, Service $service) {
      $this->validate($request, [
        'employees' => 'required',
      ]);

      $service->users()->sync($request->employees);

      Session::flash('message', 'Employee successfully assigned to service!');
      Session::flash('alert-class', 'alert-success');

      return redirect()->route("services");
    }

    public function appointments(Service $service) {
      $appointments = $service->appointments;

      return view("merchant.appointments",['appointments' => $appointments, 'service' => $service]);
    }

    public function empAppointments(Service $service) {
      $user_id = auth()->id();
      $appointments = Appointment::where("service_id",$service->id)
                      ->where("user_id",$user_id)
                      ->get();
      return view("merchant.appointments",['appointments' => $appointments, 'service' => $service]);
    }
}
