
   <!--Search Section-->
   @if(!Auth::guard('candidate')->user())
	   @include('frontend.jobs.partials.search')
	@else
		@include('frontend.jobs.partials.ln_search')
	@endif

    <!--//Search Section-->

<div class="card-wrapper @if(!Auth::guard('candidate')->user()) non-login @endif align-items-center justify-content-center mt-5">
@if(is_object($jobs) && count($jobs)>0)  
	@foreach ($jobs as $key => $job)
		<div class="card mb-3" id="job-{{Arr::get($job, 'id')}}">
			<div class="card-block" jobId="{{Arr::get($job, 'id')}}">
				<h4 class="card-title">{{ Arr::get($job, 'title')}}</h4>
				<p class="card-text">{{ config('constants.cities.'.Arr::get($job, 'city_id') )}}, {{config('constants.countries.PK')}}</p>
				<p class="card-text btn btn-primary"><a href="{{ route('jobs.detail', Arr::get($job, 'id')) }}">Apply Now</a></p>
			</div>
		</div>
	@endforeach
	@else
	 <div class="my-4">!! No Job Found !!</div>
@endif  
</div>
<div class="d-flex">
	{!! $jobs->appends(Request::except('page'))->render() !!}
</div>