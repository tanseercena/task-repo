@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Assign Employees to <strong>{{ $service->name }}</strong></div>

                <div class="card-body">
                  <form method="POST" action="{{ route('assign.employees',$service) }}">
                      @csrf

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Employee(s)') }}</label>

                          <div class="col-md-6">
                              <select class="form-control @error('employees') is-invalid @enderror" name="employees[]" multiple >
                                @foreach($employees as $employee)
                                  <option value="{{ $employee->id }}">{{ $employee->name }}</option>
                                @endforeach
                              </select>
                              @error('employees')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-8 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Assing Employees') }}
                              </button>
                          </div>
                      </div>

                  </form>
                </div>
            </div>
        </div>
    </div>
    <br />
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Assigned Employees to {{$service->name}}</div>

                <div class="card-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>Employee</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($assigned_employees as $employee)
                        <tr>
                          <td>{{ $employee->name }}</td>
                          <td>--- </td>
                        </tr>
                      @empty
                        <tr>
                          <th colspan="4">No Employee Assigned!</th>
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
