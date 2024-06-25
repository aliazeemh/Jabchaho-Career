
@extends('frontend.layouts.app-master')
@section('title', 'Jobs History')

@section('content')



<style>
.good-review-score{
    color:white;
    text-align: center;
    padding: 10px;
    margin-right: 10px;
    margin-top: 0px !important;
}

h1{
    font-size: calc(2rem + 2vw) !important;
}

.card-text:last-child {
    margin-bottom: 5px !important;
}
</style>

<div class="container mb-3">
    <div class="card">
        <div class="card-header">Jobs Applied History</div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-5" style="overflow-y: auto; height:700px; ">
                        @if(is_object($candidateJobAppliedData) && count($candidateJobAppliedData)>0)  
                        @foreach ($candidateJobAppliedData as $key => $candidateJobApplied)
                            <div class="card mb-3" id="job-{{Arr::get($candidateJobApplied->job, 'id')}}">
                                <div class="card-block" jobId="{{Arr::get($candidateJobApplied->job, 'id')}}">
                                    <h1 class="card-text good-review-score float-start"><img src="{{asset('assets/images/job-page-logo.png')}}"></h1>
                                    <h4 class="card-title"><a a href="#_" onclick="getDetail({{Arr::get($candidateJobApplied->job, 'id')}});" >{{ Arr::get($candidateJobApplied->job, 'title')}}</a></h4>
                                    <p class="card-text">{{ config('constants.cities.'.Arr::get($candidateJobApplied->job, 'city_id') )}}</p>
                                    <p class="card-text">Applied Date: {{ date('M d, Y',strtotime(Arr::get($candidateJobApplied, 'created_at'))) }}</p>
                                
                                </div>
                            </div>
                        @endforeach
                        @else
                        <div>!! No Job Found !!</div>
                        @endif  
                    </div>

                    <div id="jobDetailData" class="col-md-7 max-w-4xl mx-auto px-10 py-6  rounded-lg shadow-md">
                        Please wait...
                    </div>
                </div>    
            </div>
        </div>
    </div>                    
</div>

   
<script>
	$(document).ready(function() {
		var jobId = $(".card-block:first-child").attr('jobId');
		getDetail(jobId);
	});


	function getDetail(jobId)
	{
		if(jobId)
		{
			//bg-white
			$("#jobDetailData").addClass("bg-white");
			$(".card").removeAttr("style");
			$("#job-"+jobId).css({ 'background-color': "#f8f9fd" });

			$.ajax({
				type:'GET',
				url: "{{ route('history.jobs.detail')}}/"+jobId,
				cache:false,
				contentType: false,
				processData: false,
				success:function(data)
				{
					$('#jobDetailData').html(data);
				},
				error: function(data)
				{
					$('#jobDetailData').html('');
					console.log(data);
				}
			});
		}
		else{
			$("#jobDetailData").removeClass("bg-white");
			$('#jobDetailData').html('');
		}
		
	}    
</script>

@endsection