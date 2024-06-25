
<div class="mb-2">
   <div class="card">
      <div class="card-body">
         <div class="col-md-12">        
                <a href="{{ route('jobs.list') }}" >> Back to Jobs</a>
                <h2>{{ Arr::get($jobDetail, 'title') }}</h2>  
                <div class="mx-auto">
                        <div class="mt-3">
                                <span class="font-normal text-sm text-gray-600">Posted on @if(!empty(Arr::get($jobDetail, 'updated_at'))){{ date("M d, Y", strtotime(Arr::get($jobDetail, 'updated_at'))) }}@endif</span>
                                @if(empty($alreadyApplied))
                                <button type="submit" class="btn btn-primary apply la-button float-end">Apply</button>
                                @else
                                <span class="float-end alert alert-danger"> Already applied on this job </span>
                                @endif
                        </div>
                        <p class="mt-4 mb-2 fw-bold">Title</p>  
                        <p class="ms-5 uppercase text-gray-600 f-18px fw-600 tt-capitalize">{{ Arr::get($jobDetail, 'title') }}</p>
                        
                        <p class="mt-4 mb-2 fw-bold">Apply before </p>  
                        <p class="ms-5 uppercase text-gray-600">{{ date('M d, Y',strtotime(Arr::get($jobDetail, 'end_date'))) }}</p>


                        <p class="mt-4 mb-2 fw-bold">City</p> 
                        <p class="ms-5 uppercase text-gray-600">{{ $jobcityName }}</p>

                        <p class="mt-4 mb-2 fw-bold">Responsibilities</p> 
                        <p class="ms-5 uppercase text-gray-600">{!! Arr::get($jobDetail, 'responsibility') !!}</p>

                        <p class="mt-4 mb-2 fw-bold">Requirements</p> 
                        <p class="ms-5 uppercase text-gray-600">{!! Arr::get($jobDetail, 'requirement') !!}</p>


                        <p class="mt-4 mb-2 fw-bold">Benefits</p> 
                        <p class="mb-2  uppercase text-gray-600">
                                @if(!empty($jobPostedBenefits))
                                <ul>
                                @foreach($jobPostedBenefits as $jobPostedBenefit)
                                <li> {{ Arr::get($jobPostedBenefit->jobBenefit, 'name') }}</li> 
                                @endforeach
                                </ul>
                                @endif
                        </p>
                </div> 
                
        
        </div>
      </div>
   </div>
</div>    


<script>
$('.apply').click(function(){
   window.location.href="{{ route('apply.job', Arr::get($jobDetail, 'id')) }}";
})
</script>