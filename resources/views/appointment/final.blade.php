<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Scripts -->
        <script src="https://code.jquery.com/jquery-3.5.1.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}" defer></script>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <style>
            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100vh;
                margin: 0;
            }

            .full-height {
                height: 100vh;
            }

            .flex-center {
                align-items: center;
                display: flex;
                justify-content: center;
            }

            .position-ref {
                position: relative;
            }

            .top-right {
                position: absolute;
                right: 10px;
                top: 18px;
            }

            .content {
                text-align: center;
            }

            .title {
                font-size: 84px;
            }

            .links > a {
                color: #636b6f;
                padding: 0 25px;
                font-size: 13px;
                font-weight: 600;
                letter-spacing: .1rem;
                text-decoration: none;
                text-transform: uppercase;
            }

            .m-b-md {
                margin-bottom: 30px;
            }
        </style>
    </head>
    <body>
        <div class="flex-center position-ref full-height">
            @if (Route::has('login'))
                <div class="top-right links">
                    @auth
                        <a href="{{ url('/home') }}">Home</a>
                    @else
                        <a href="{{ route('login') }}">Login</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif

            <div class="content">
                <div class="title m-b-md">
                    Book Your Appointment
                </div>

                <div class="links">
                  <div class="container">
                    <div class="row justify-content-center">
                  @if(Session::has('message'))
                    <p class="alert {{ Session::get('alert-class', 'alert-info') }}">{{ Session::get('message') }}</p>
                  @endif
                    </div>
                  </div>

                    <form method="post" action="{{ route('book.appointment') }}">
                      @csrf
                      <input type="hidden" name="step" value="4">
                      <input type="hidden" name="collaborator" value="{{$collaborator->id}}">
                      <input type="hidden" name="service" value="{{ $service->id }}">
                      <input type="hidden" name="date" value="{{ $date }}">

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Collaborator') }}</label>

                          <div class="col-md-6 text-left">
                              <strong>{{ $collaborator->name }}</strong>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Service') }}</label>

                          <div class="col-md-6 text-left">
                              <strong>{{ $service->name }}</strong>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Booking Date') }}</label>

                          <div class="col-md-6 text-left">
                              <strong>{{ $date }}</strong>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Select Timing') }}</label>

                          <div class="col-md-6">
                              @foreach($array_of_time as $time)
                                <input type="radio" class="@error('timing') is-invalid @enderror" name="timing" {{ $time['status'] == false ? '' : 'disabled' }} value="{{$time['value']}}"> {{$time['value']}}
                              @endforeach

                              @error('timing')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Your Name') }}</label>

                          <div class="col-md-6">
                              <input type="text" name="customer_name" class="form-control @error('customer_name') is-invalid @enderror" />

                              @error('customer_name')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Your Email') }}</label>

                          <div class="col-md-6">
                              <input type="text" name="customer_email" class="form-control @error('customer_email') is-invalid @enderror" />

                              @error('customer_email')
                                  <span class="invalid-feedback" role="alert">
                                      <strong>{{ $message }}</strong>
                                  </span>
                              @enderror
                          </div>
                      </div>

                      <div class="form-group row mb-0">
                          <div class="col-md-4 offset-md-4">
                              <button type="submit" class="btn btn-primary">
                                  {{ __('Continue') }}
                              </button>
                          </div>
                      </div>

                    </form>
                </div>
            </div>
        </div>
    </body>
</html>
