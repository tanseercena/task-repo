@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Employees
                  <a href="{{ route('add.employee') }}" class="btn btn-primary btn-sm">Add Employee</a>
                </div>

                <div class="card-body">
                  <table class="table table-striped">
                    <thead>
                      <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                      @forelse($employees as $employee)
                        <tr>
                          <td>{{ $employee->id }}</td>
                          <td>{{ $employee->name }}</td>
                          <td>{{ $employee->email }}</td>
                          <td>--- </td>
                        </tr>
                      @empty
                        <tr>
                          <th colspan="4">No Employee Found!</th>
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
