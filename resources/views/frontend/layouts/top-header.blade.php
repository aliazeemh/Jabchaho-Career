<header class="p-3 bg-dark tc-white-imp p-absolute w-100 header-blade ff-gothambook ">
  <div class="container jc-left top-header-container">
        <a class="navbar-brand" href="{{route('landing.page')}}"><img src="{{asset('assets/images/jabchaho-logo.svg')}}" /></a>
        <ul class="custom-nav">
            <li class="a-s-center "><a href="#_" class="nav-link f-18px px-2 tc-white-imp">{{Auth::guard('candidate')->user()->full_name}}</a></li>  
            <li class="nav-item dropdownt">
                <a class="nav-link px-2 dropdown-toggle profileDiv" href="#" role="button" data-bs-toggle="dropdown">
                    
                    @if(!empty(Auth::guard('candidate')->user()->profile_image))
                        <img src="{{asset(config('constants.files.profile'))}}/{{Auth::guard('candidate')->user()->profile_image}}" class="dropdownImage" >
                    @else
                        <img src="{{asset('assets/images/default/profile.jpg')}}" class="dropdownImage">
                    @endif
                
                </a>
                <div class="dropdown-menu profile-in">
                    <ul class="bg-dark">
                        <li><a href="{{route('index')}}" class="dropdown-item  tc-white-imp">Home</a></li> 
                        <!--<li><a href="{{route('tips-and-guides.index')}}" class="dropdown-item  tc-white-imp">Tips And Guides</a></li>-->
                        <li><a class="dropdown-item  tc-white-imp" data-toggle="modal" data-target="#myModal" id="open">Change Password</a></li>
                        <li><a href="{{route('signout.perform')}}" class="dropdown-item  tc-white-imp">Signout</a></li> 
                    </ul>
                </div>
            </li>
        </ul>
    </div>
</header>
