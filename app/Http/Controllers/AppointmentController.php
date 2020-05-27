<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Service;
use App\Appointment;
use DB;
use Session;

class AppointmentController extends Controller
{
    public function book(Request $request) {
      $step = $request->step;
      switch($step) {
        case 1:
          return $this->processStep1($request);
          break;
        case 2:
          return $this->processStep2($request);
          break;
        case 3:
          return $this->processStep3($request);
          break;
        case 4:
          return $this->processStepFinal($request);
          break;


        default:
      }

    }

    public function processStep1($request) {
      $this->validate($request, [
        'collaborator' => 'required',
      ]);

      return redirect()->route('appointment.step2',['user_id' => $request->collaborator]);
    }

    public function step2($user_id){
      $collaborator = User::find($user_id);
      $services = $collaborator->services;
      return view('appointment.step2', ['collaborator' => $collaborator, 'services' => $services]);
    }

    public function processStep2($request){
      $this->validate($request, [
        'service' => 'required',
      ]);

      return redirect()->route('appointment.step3',['user_id' => $request->collaborator, 'service' => $request->service]);
    }

    public function step3($user_id, $service_id) {
      $collaborator = User::find($user_id);
      $service = Service::find($service_id);

      $timing_from = $service->timing_from;
      $timing_to = $service->timing_to;

      return view('appointment.step3',
        [
          'collaborator' => $collaborator,
          'service' => $service
        ]);
    }

    public function processStep3($request) {
      $this->validate($request, [
        'date' => 'required',
      ]);

      return redirect()->route('appointment.step4',
      [
        'user_id' => $request->collaborator,
        'service' => $request->service,
        'date' => $request->date
      ]);
    }

    public function step4($user_id, $service_id, $date) {

      $collaborator = User::find($user_id);
      $service = Service::find($service_id);

      $starttime = $service->timing_from.':00';  // start time
      $endtime = $service->timing_to.':00';  // End time
      $duration = '30';  // split by 30 mins

      $array_of_time = array ();
      $start_time    = strtotime ($starttime); //change to strtotime
      $end_time      = strtotime ($endtime); //change to strtotime

      $add_mins  = $duration * 60;

      while ($start_time <= $end_time) // loop between time
      {
         $time = [];
         $end = $start_time+$add_mins;
         $time['value'] = date("h:i", $start_time) .' - '. date("h:i", $end);
         $time['status'] = $this->checkStatus(date("h:i", $start_time), date("h:i", $end), $service->id, $collaborator->id, $date);
         $array_of_time[] = $time;
         $start_time += $add_mins; // to check endtie=me
      }

      // check if allowed people booked their appointments
      $all_booked = $this->checkAllBooked($service, $collaborator, $date);
      if($all_booked) {
        Session::flash('message', 'All slots are booked for selected date!');
        Session::flash('alert-class', 'alert-danger');
        return redirect()->route('start');
      }

      return view('appointment.final',
        [
          'collaborator' => $collaborator,
          'service' => $service,
          'date' => $date,
          'array_of_time' => $array_of_time,
        ]);
    }

    public function processStepFinal($request) {
      $this->validate($request, [
        'timing' => 'required',
        'customer_email' => 'required',
        'customer_name' => 'required'
      ]);

      $collaborator = User::find($request->collaborator);
      $service = Service::find($request->service);
      $date = $request->date;
      $timing = explode('-',$request->timing);

      $start_time = trim($timing[0]);
      $end_time = trim($timing[1]);

      $check_slot = $this->checkStatus($start_time,$end_time,$service->id, $collaborator->id, $date);
      if($check_slot) {
        Session::flash('message', 'Sorry, selected slot is already booked!');
        Session::flash('alert-class', 'alert-danger');
        return redirect()->back();
      }

      //Save appointment
      DB::beginTransaction();

      try{
          // Step 1 : Again check if slot is not booked
          $check_slot = $this->checkStatus($start_time,$end_time,$service->id, $collaborator->id, $date);
          if($check_slot) {
            throw new \Exception('Slot already booked');
          }
          // check if allowed people booked their appointments
          $all_booked = $this->checkAllBooked($service, $collaborator, $date);
          if($all_booked) {
            throw new \Exception('All slots are booked');
          }
      }catch(\Exception $e){
          // DB::rollback();
          Session::flash('message', 'Sorry, selected slot is already booked!');
          Session::flash('alert-class', 'alert-danger');
          return redirect()->route('appointment.step4',
          [
            'user_id' => $collaborator->id,
            'service' => $service->id,
            'date' => $date
          ]);
      }

      try{
          //Step 3 : Book appointment
          $appt = new Appointment();
          $appt->user_id = $collaborator->id;
          $appt->service_id = $service->id;
          $appt->booking_date = date("Y-m-d",strtotime($date));
          $appt->booking_from = $start_time;
          $appt->booking_to = $end_time;
          $appt->customer_email = $request->customer_email;
          $appt->customer_name = $request->customer_name;
          $appt->save();
      }catch(\Exception $e){
          DB::rollback();
          Session::flash('message', 'Sorry, Something went wrong.!');
          Session::flash('alert-class', 'alert-danger');
          return redirect()->route('appointment.step4',
          [
            'user_id' => $collaborator->id,
            'service' => $service->id,
            'date' => $date
          ]);
      }
      DB::commit();

      return redirect()->route('finish',['id' => $appt->id]);
    }

    public function finish($id) {
      $appt = Appointment::findOrFail($id);

      Session::flash('message', 'Congratulation! Your appointment has successfully booked.!');
      Session::flash('alert-class', 'alert-success');

      return view("appointment.finish",['appt' => $appt]);
    }

    private function checkStatus($start_time, $end_time, $service_id, $user_id, $date) {
      $appt = Appointment::where("user_id",$user_id)
              ->where("service_id",$service_id)
              ->whereDate("booking_date",$date)
              ->where("booking_from",$start_time)
              ->where("booking_to",$end_time)
              ->get();
      if($appt->count() > 0) {
        return true;
      }
      return false;
    }

    private function checkAllBooked($service, $collaborator, $date) {
      $appt = Appointment::where("user_id",$collaborator->id)
              ->where("service_id",$service->id)
              ->whereDate("booking_date",$date)
              ->get();
      if($appt->count() < $service->people) {
        return false;
      }
      return true;
    }


}
