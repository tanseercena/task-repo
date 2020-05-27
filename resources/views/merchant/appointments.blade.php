@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Appointments for <strong>{{ $service->name }}</strong>
                </div>

                <div class="card-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Customer Email</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Timing</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($appointments as $appt)
                        <tr>
                          <td>{{ $appt->id }}</td>
                          <td>{{ $appt->customer_name }}</td>
                          <td>{{ $appt->customer_email }}</td>
                          <td>{{ $appt->user->name }}</td>
                          <td>{{ $appt->booking_date }}</td>
                          <td>{{ $appt->booking_from }} - {{ $appt->booking_to }}</td>
                        </tr>
                      @empty
                        <tr>
                          <th colspan="6">No Appointment Found!</th>
                        </tr>
                      @endforelse
                    </tbody>
                  </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
