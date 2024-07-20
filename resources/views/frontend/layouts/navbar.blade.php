<header class="p-3 bg-dark text-white header-blade ff-gothambook">
  <div class="container jc-left">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark jc-left">
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
      </button>
        <a class="navbar-brand" href="{{route('landing.page')}}"><img src="{{asset('assets/images/jabchaho-logo.svg')}}" /></a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <div class="nav-pos">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item active"><a href="{{ route('landing.page') }}" class="nav-link px-2 f-14px">Home</a></li>
              <li  class="nav-item"><a href="{{ route('cms.pages','about-us') }}" class="nav-link px-2 f-14px">About us</a></li>
              <li  class="nav-item"><a href="{{ route('jobs.list') }}" class="nav-link px-2 f-14px">Current Job Openings</a></li>
              @if(!Auth::guard('candidate')->user())
                <li class="nav-item"><a href="{{ route('drop.your.cv') }}" class="nav-link px-2 f-14px">DROP YOUR CV</a></li>
              @endif
              <li class="nav-item"><a href="{{ route('candidate.refer') }}" class="nav-link px-2 f-14px">Refer a candidate</a></li>
            </ul>
            
            <ul class="navbar-nav mr-auto">
              @if(!Auth::guard('candidate')->user())
                <li class="nav-item"><a href="{{ route('signin.show') }}" class="nav-link px-2 f-14px">LOGIN</a></li>
                <span class="mobile-hide"> | </span>  
                <li class="nav-item"><a href="{{ route('signup.show') }}" class="nav-link px-2 f-14px">REGISTER</a></li>
              @else
              <li class="nav-item"><a href="{{ route('view.profile') }}" class="nav-link px-2 f-14px">PROFILE</a></li>
              @endif
            </ul>
            
          </div>
        </div>
    </nav>    
  </div>
</header>
<div class="p-absolute w-100 h-300px banner-cover"></div>
<script src="{{asset('assets/js/navbar-header.js')}}"></script>