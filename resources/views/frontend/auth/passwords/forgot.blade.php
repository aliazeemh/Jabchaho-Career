@extends('frontend.layouts.auth-master')
@section('title', 'Forgot Password')
@section('content')

<div class="container-auth">
    <div class="container signin">
        <h2>Forgot Password</h2>
        
        @include('frontend.includes.partials.messages')

        <form name="reset" onkeypress="return event.keyCode != 13;" method="post" action="{{ route('forgot.password.perform') }}"  class="form-horizontal col-md-12"  >
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="form-group col">
                <input type="text" autocomplete="off" class="form-control" id="email"  name="email" maxlength="50" placeholder="Email Address" value="{{old('email')}}">
                @if($errors->has('email'))
                    <div class="text-danger">{{ $errors->first('email') }}</div>
                @endif
            </div>
            <div class="form-group col form-submit">        
                
                <div><button type="submit" class="btn btn-primary jabchaho-brand">Send</button></div>  
                <div class="already-user">Already have an account! <a href="{{route('signin.show')}}">Signin</a></div>
                
                </div>
            </div>
            


        </form>
    </div>
</div>

@endsection