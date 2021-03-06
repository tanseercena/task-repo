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

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Collaborator') }}</label>

                          <div class="col-md-6 text-left">
                              <strong>{{ $appt->user->name }}</strong>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Service') }}</label>

                          <div class="col-md-6 text-left">
                              <strong>{{ $appt->service->name }}</strong>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Booking Date') }}</label>

                          <div class="col-md-6 text-left">
                              <strong>{{ $appt->booking_date }}</strong>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Timing') }}</label>

                          <div class="col-md-6 text-left">
                            <strong>{{ $appt->booking_from }} - {{ $appt->booking_to }}</strong>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Your Name') }}</label>

                          <div class="col-md-6 text-left">
                            <strong>{{ $appt->customer_name }}</strong>
                          </div>
                      </div>

                      <div class="form-group row">
                          <label class="col-md-4 col-form-label text-md-right">{{ __('Your Email') }}</label>

                          <div class="col-md-6 text-left">
                            <strong>{{ $appt->customer_email }}</strong>
                          </div>
                      </div>


                </div>
            </div>
        </div>
    </body>
</html>
