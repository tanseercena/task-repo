@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Services
                  @role('merchant')
                  <a href="{{ route('add.service') }}" class="btn btn-primary btn-sm">Add Service</a>
                  @endrole
                </div>

                <div class="card-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Timing (From)</th>
                        <th>Timing (To)</th>
                        <th>Allowed People</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($services as $service)
                        <tr>
                          <td>{{ $service->id }}</td>
                          <td>{{ $service->name }}</td>
                          <td>{{ $service->timing_from }}</td>
                          <td>{{ $service->timing_to }}</td>
                          <td>{{ $service->people }}</td>
                          <td>
                            @role('merchant')
                            <a href="{{ route('assign.employee',$service) }}" class="btn btn-info btn-sm">Assign Employee</a>
                            |

                            <a href="{{ route('service.appointments',$service) }}" class="btn btn-info btn-sm">Appointments</a>
                            @endrole

                            @role('employee')
                            <a href="{{ route('emp.service.appointments',$service) }}" class="btn btn-info btn-sm">Appointments</a>
                            @endrole
                          </td>
                        </tr>
                      @empty
                        <tr>
                          <th colspan="6">No Service Found!</th>
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
