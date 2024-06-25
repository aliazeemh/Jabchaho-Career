@extends('frontend.layouts.auth-master')
@section('title', 'Login')
@section('content')


<div class="container-auth">
  <div class="container signin">
    <h2 class="header">Login</h2>
    <div class="desc">Login with your account</div>
      
      @include('frontend.includes.partials.messages')

    <form class="form-horizontal signin-auth" method="post" action="{{ route('signin.perform') }}" autocomplete="off">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />
      <div class="form-group">
        <div class="col-sm-12">
          <input type="text" autocomplete="off" class="form-control" id="email" name="email" maxlength="50" value="{{old('email')}}" placeholder="Enter your Phone Number or Email Address">
          @if($errors->has('email'))
            <div class="text-danger">{{ $errors->first('email') }}</div>
          @endif
        </div>
      </div>
      <div class="form-group">
        <div class="col-sm-12">          
          <input type="password" autocomplete="off" class="form-control" name="password" placeholder="Enter your Password" >
          @if($errors->has('password'))
            <div class="text-danger">{{ $errors->first('password') }}</div>
          @endif
        </div>
      </div>
      <div class="form-group">        
        <div class="col-sm-6 remember-pass">
          <span class="checkbox">
            <label class="label-wrap"><input type="checkbox" name="remember" value="1" class="form-check-input" checked> <span class="checkbox-label"> Remember me</span></label>
          </span>
        </div>
        <div class="col-sm-6 t-a-right forget-password">
          <span class="">
                  <a href="{{route('forgot.password.show')}}">Forgot Password</a>
          </span>
        </div>
      </div>
      <div class="form-group">        
        <div class="col-sm-12 t-a-center">
          <button type="submit" class="btn btn-primary ideas-brand">Login</button>   
        </div>
      </div>
      <div class="form-group">        
        <div class="col-sm-12 t-a-center acc-signup">
          <span>Don't have an account yet?</span>
          <span class="">
            <a href="{{route('signup.show')}}">Signup</a>
          </span>
        </div>
      </div>
      <div class="form-group text-center social-btn">        
        <div class=" col-sm-12">
              <!--<a href="{{ route('facebook.login') }}" class="btn btn-primary btn-block"><i class="fa fa-facebook"></i><span class="social-login-btn">Sign in with <b>Facebook</b></span></a>-->
              <a href="{{ route('google.login') }}" class="btn btn-danger btn-block"><i class="fa fa-google"></i><span  class="social-login-btn">Sign in with <b>Google</b></span></a>
              <!--<a href="#" class="btn btn-info btn-block"><i class="fa fa-twitter"></i> Sign in with <b>Twitter</b></a>-->
        </div>
        
      </div>
    
    </form>
  </div>
</div>



@endsection
