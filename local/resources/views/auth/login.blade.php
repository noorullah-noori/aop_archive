@extends('layouts.app')
@section('title','Login')
@section('content')

    <div class="container">
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                      <h4 class="text-center">
                        سیستم آرشیف ارگ
                      </h4>
                    </div>
                    <div class="card-body">
                        {{-- <h5 class="text-center">به سیستم آرشیف ارگ خوش آمدید</h5> --}}
                        <img src="{{asset('assets/images/arg.png')}}" alt="" class="d-block mx-auto" style="width:250px;">
                        <h4 class="card-title text-center my-3">ورود به سیستم</h4>
                        <form class="form-horizontal my-3" role="form" method="POST" action="{{ url('/login') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="email" class="form-control" name="email" placeholder="ایمیل"
                                           value="{{ old('email') }}"  onkeydown="keydownFunction()" id="email">

                                    @if ($errors->has('email'))
                                        <span class="form-text text-muted">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">

                                <div class="col-md-12">
                                    <input type="password" class="form-control" placeholder="رمز عبور" name="password" id="password" onkeydown="PasswordkeydownFunction()">

                                    @if ($errors->has('password'))
                                        <span class="form-text text-muted">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>
{{--
                            <div class="form-group">
                                <div class="col-md-12">
                                    <div class="checkbox">
                                        <label>
                                            <input type="checkbox" name="remember"> Remember Me
                                        </label>
                                    </div>
                                </div>
                            </div> --}}

                            <div class="form-group">
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-btn fa-sign-in"></i>ورود
                                    </button>

                                    <a class="btn btn-link forgot" href="#">تغییر رمز عبور</a>

                                </div>
                            </div>
                            <div class="form-group forgot-message d-none">
                                <div class="col-md-12">
                                  <div class="alert alert-warning ">
                                    برای تغییر دادن رمز عبور لطفا با تیم ویب سایت ریاست تکنالوژی معلوماتی به تماس شوید
                                  </div>

                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('custom-css')
  <style>

    img.rounded-circle {
      width:96px;
    }
    .card {
      border: none;
      border-radius: 0;
      box-shadow: 0px 0px 7px 0px #000;
      filter: opacity(.95);
    }
    .forgot-message {
      font-size: .7em;
    }
    .forgot {
      padding-right: 0;
    }
    /* input[type='email']:focus{
        text-align:left;
  }
    input[type='password']:focus{
        text-align:left;
  } */
}
  </style>

@endpush
@push('custom-js')
  <script>
    $('a.forgot').click(function() {
      $('.form-group.forgot-message').toggleClass('d-none');
    });

    function keydownFunction(){
      $("#email").css("text-align", "left");

    }
    function PasswordkeydownFunction(){
      $("#password").css("text-align", "left");

    }
  </script>

@endpush
