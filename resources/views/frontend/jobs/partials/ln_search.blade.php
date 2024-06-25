<div class="job-login-search">
    <h2 style="color:#8cc63f">Ideas Job Openings</h2>
    <form method="GET" action="{{ route('jobs.list') }}">
        <div class="row">   
            
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
        </div>
    </form>
</div>
<script type="text/javascript">
    var selectElem = document.querySelectorAll(".job-login-search select");
    var jobSForm = document.querySelector(".job-login-search form");
    selectElem.forEach(element => {
        element.onchange = function()
        {
            jobSForm.submit();
        }
    });
</script>