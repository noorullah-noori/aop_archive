@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-md-center mt-5">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                      <img src="{{asset('images/login_avatar.png')}}" alt="" class="d-block mx-auto my-3 rounded-circle">
                        <h4 class="card-title text-center">ثبت یوزر جدید</h4>
                        <form class="form-horizontal" role="form" method="POST" action="{{ url('/register') }}">
                            {!! csrf_field() !!}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="text" class="form-control" placeholder="اسم" name="name" value="{{ old('name') }}">

                                    @if ($errors->has('name'))
                                        <span class="form-text text-muted">
                                            {{ $errors->first('name') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="email" class="form-control" placeholder="ایمیل" name="email" value="{{ old('email') }}">

                                    @if ($errors->has('email'))
                                        <span class="form-text text-muted">
                                            {{ $errors->first('email') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="password" class="form-control" placeholder="رمز عبور" name="password">

                                    @if ($errors->has('password'))
                                        <span class="form-text text-muted">
                                            {{ $errors->first('password') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('password_confirmation') ? ' has-error' : '' }}">
                                <div class="col-md-12">
                                    <input type="password" class="form-control" placeholder="تکرار رمز عبور" name="password_confirmation">

                                    @if ($errors->has('password_confirmation'))
                                        <span class="form-text text-muted">
                                            {{ $errors->first('password_confirmation') }}
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-12 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary btn-block">
                                        <i class="fa fa-btn fa-user"></i>ثبت
                                    </button>
                                </div>
                            </div>
                        </form>
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
  </style>

@endpush
