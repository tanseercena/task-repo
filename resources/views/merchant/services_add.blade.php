@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Add Service</div>

                <div class="card-body">
                  <form method="POST" action="{{ route('save.service') }}">
                      @csrf

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Service Name') }}</label>

                          <div class="col-md-6">
                              <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autofocus>

                              @error('name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Timing') }}</label>

                          <div class="col-md-6">
                              From:
                              <select class="form-control @error('timing_from') is-invalid @enderror" name="timing_from">
                                @for($i=1; $i<=24; $i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                              </select>
                              @error('timing_from')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                              To:
                              <select class="form-control @error('timing_to') is-invalid @enderror" name="timing_to">
                                @for($i=1; $i<=24; $i++)
                                  <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                              </select>
                              @error('timing_to')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('People Allowed') }}</label>

                          <div class="col-md-6">
                              <input type="number" class="form-control @error('people') is-invalid @enderror" name="people" value="{{ old('people') }}" required>

                              @error('people')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-8 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Add Service') }}
                              </button>
                          </div>
                      </div>

                  </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
