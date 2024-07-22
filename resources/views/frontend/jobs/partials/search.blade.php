<div class="job-search">
    <h2 class="t-white ff-gothambook">Join <span><img class="logo" src="{{asset('assets/images/jabchaho-logo.svg')}}" /></span> to Achieve A Great Career in Laundry Services</h2>
    <div class="t-white">Find the perfect job to build your future</div>
    <form method="GET" action="{{ route('jobs.list') }}">
        <div class="row">
            
            <div class="col">
                <input type="text" class="form-control" placeholder="Job title" name='title' value="@if(!empty($title)){{$title}}@endif">
                <label class="f-right hide">
                    <span class="fa fa-search search-icon"></span>
                    <input type="submit" class="btn btn-primary btn-sm" value="Search">
                </label>
            </div>
            
            <div class="col">
                <select class="form-control" id="city"  name="city" rel="@if(!empty($city)){{$city}}@endif" >
                    <option value="">Select City</option>
                    @if(!empty($cities) )
                        @foreach($cities as $key =>$value)
                            @if (!empty($city) && $city == $key)
                                <option  value="{{trim($key)}}" selected> {{trim($value)}} </option>  
                            @else    
                                <option  value="{{trim($key)}}" > {{trim($value)}} </option>
                            @endif    
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col">
                <select class="form-control" id="category"  name="category" >
                    <option value="">All Categories</option>
                    @if(!empty($areaOfInterestGroups) )
                        @foreach($areaOfInterestGroups as $areaOfInterestGroup)
                            @if (!empty($category) && $category== Arr::get($areaOfInterestGroup, 'id'))
                            <option  value="{{trim(Arr::get($areaOfInterestGroup, 'id'))}}" selected >{{trim(Arr::get($areaOfInterestGroup, 'name'))}}</option>
                            @else   
                                <option  value="{{trim(Arr::get($areaOfInterestGroup, 'id'))}}" >{{trim(Arr::get($areaOfInterestGroup, 'name'))}}</option>
                            @endif  
                        @endforeach
                    @endif
                </select>
            </div>

            <div class="col">
                <select class="form-control" id="jobType"  name="jobType" >
                    <option value="">Job Types</option>
                    @if(!empty($jobTypes) )
                        @foreach($jobTypes as $jobType)
                            @if(!empty($jobTypeSelectedId) && $jobTypeSelectedId == Arr::get($jobType, 'id'))
                                <option value="{{ trim(Arr::get($jobType, 'id')) }}" selected>{{trim(Arr::get($jobType, 'name'))}}</option> 
                            @else
                                <option  value="{{trim(Arr::get($jobType, 'id'))}}" >{{trim(Arr::get($jobType, 'name'))}}</option>
                            @endif
                        @endforeach
                    @endif
                </select>
            </div>
            
            <div class="col1-12 hide">
                <label>
                    <span class="fa fa-search search-icon tc-white"></span>
                    <input type="submit" class="btn btn-primary btn-sm" value="Search">
                </label>
            </div>
            <div class="col1-12 hide">
                <label>
                    <span class="fa fa-undo search-icon tc-white"></span>
                    <a href="@if($methodName == 'landingPage'){{ route('landing.page') }} @else {{ route('jobs.list') }} @endif" class="btn btn-primary btn-sm">Reset</a>
                </label>
            </div>
            <div class="col1-12 search-icon-wrapper">
                <label class="f-right">
                    <span class="fa fa-search search-icon tc-white"></span>
                    <input type="submit" class="btn btn-primary btn-sm hide-desktop" value="Search">
                </label>
            </div>
        </div>
    </form>
    <div class="popular-search"><span class="tc-white">Popular Searches: </span><div><span class="tc-yelllow">Machine Operator</span><span class="tc-yelllow"> | </span><span class="tc-yelllow">Ware House Manager</span><span class="tc-yelllow"> | </span><span class="tc-yelllow">Packaging</span><span class="tc-yelllow"> | </span><span class="tc-yelllow">Riders</span></div></div>
</div>