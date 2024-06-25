@extends('backend.layouts.app-master')

@section('content')
<style>
@media (min-width:1025px) {
    .col-xl-3 
    {
        width: 20% !important;
    }
}


.widget-heading{
    font-size: 14px;
}
</style>
<script src="{!! url('assets/js/charts/chart.min.js') !!}"></script>

<div class="row  mb-3">
    <div class="col-md-6 col-xl-4"><h4>Dashboard</h4></div>
    <div class="col-md-6 col-xl-4">&nbsp;</div>
    <div class="col-md-6 col-xl-4 text-end">
        <button type="button" data-value="" class="btn btn-primary filters btn-sm">All</button>
        <button type="button" data-value="day" class="btn btn-outline-primary filters btn-sm">Day</button>
        <button type="button" data-value="week" class="btn btn-outline-primary filters btn-sm">Week</button>
        <button type="button" data-value="month" class="btn btn-outline-primary filters btn-sm">Month</button>
        <button type="button" data-value="3-months" class="btn btn-outline-primary filters btn-sm">3 Months</button>
    </div>
</div>
<div>
    <div class="row mb-3">
        <div class="col-md-3 col-xl-3">
            <div class="card mb-2 widget-content bg-plum-plate">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('users.index'))
                                <a href="#" data-url="{{ route('users.index') }}" class="widgetUrl text-white text-decoration-none">Users</a>
                            @else
                                Users
                            @endif    
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-users"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card mb-2 widget-content bg-arielle-candidates">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('candidates.index')) 
                                <a href="#" data-url="{{ route('candidates.index') }}" class="widgetUrl text-white text-decoration-none">Candidates</a>
                            @else
                                Candidates
                            @endif      
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-candidates"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card mb-2 widget-content bg-night-fade">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('jobs.index'))
                                <a href="#" data-url="{{ route('jobs.index') }}?job_status_id={{config('constants.job_statuses.active_jobs')}}" class="widgetUrl text-white text-decoration-none">Jobs</a>
                            @else
                                Jobs
                            @endif    
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-active-jobs"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-mixed-hopes">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}" class="widgetUrl text-white text-decoration-none">Applications</a>
                            @else
                                Applications
                            @endif
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-applications"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-happy-green">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.applied')}}" class="widgetUrl text-white text-decoration-none">Applied</a>
                            @else
                                Applied
                            @endif    
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-Applied"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-md-3 col-xl-3">
            <div class="card mb-2 widget-content bg-plum-plate">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.shortlisted')}}" class="widgetUrl text-white text-decoration-none">Shortlisted</a>
                            @else
                                Shortlisted
                            @endif   
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-Shortlisted"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card mb-2 widget-content bg-arielle-candidates">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.interview_cleared')}}" class="widgetUrl text-white text-decoration-none">Interview Cleared </a>
                            @else
                                Interview Cleared 
                            @endif     
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-InterviewCleared"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card mb-2 widget-content bg-night-fade">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.interview_failed')}}" class="widgetUrl text-white text-decoration-none">Interview Failed</a>
                            @else
                                Interview Failed
                            @endif      
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-InterviewFailed"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-mixed-hopes">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.on_hold')}}" class="widgetUrl text-white text-decoration-none">On Hold</a>
                            @else
                                On Hold
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-OnHold"></span></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-happy-green">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.hired')}}" class="widgetUrl text-white text-decoration-none">Hired</a>
                            @else
                                Hired
                            @endif     
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-Hired"></span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mb-3">

        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-plum-plate">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.not_appeared')}}" class="widgetUrl text-white text-decoration-none">Not Appeared </a>
                            @else
                                Not Appeared 
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-NotAppeared"></span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-arielle-candidates">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.not_shortlisted')}}" class="widgetUrl text-white text-decoration-none">Not Shortlisted</a>
                            @else
                                Not Shortlisted
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-Notshortlisted"></span></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-night-fade">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.interview_scheduled')}}" class="widgetUrl text-white text-decoration-none">Interview Scheduled</a>
                            @else
                                Interview Scheduled 
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-InterviewScheduled"></span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-mixed-hopes">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.offer_declined')}}" class="widgetUrl text-white text-decoration-none">Offer Declined</a>
                            @else
                                Offer Declined
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-OfferDeclined"></span></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-happy-green">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.interview_not_scheduled')}}" class="widgetUrl text-white text-decoration-none">Interview Not Scheduled</a>
                            @else
                                Interview Not Scheduled 
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-InterviewNotScheduled"></span></div>
                    </div>
                </div>
            </div>
        </div>




    </div>
    <div class="row mb-3">

        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-plum-plate">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.screening_pending')}}" class="widgetUrl text-white text-decoration-none">Screening Pending </a>
                            @else
                                Screening Pending
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-ScreeningPending"></span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-arielle-candidates">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.interview_to_be_schedule')}}" class="widgetUrl text-white text-decoration-none">Interview To Be Schedule</a>
                            @else
                                Interview To Be Schedule
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-InterviewToBeSchedule"></span></div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-night-fade">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.internship_offered')}}" class="widgetUrl text-white text-decoration-none">Internship Offered</a>
                            @else
                                Internship Offered
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-InternshipOffered"></span></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-3 col-xl-3">
            <div class="card mb-1 widget-content bg-mixed-hopes">
                <div class="widget-content-wrapper text-white">
                    <div class="widget-content-left">
                        <div class="widget-heading">
                            @if(Auth::user()->can('applicants.index'))
                                <a href="#" data-url="{{ route('applicants.index') }}?applicant_status_id={{config('constants.applicant_status_id.offer_accepted')}}" class="widgetUrl text-white text-decoration-none">Offer Accepted</a>
                            @else
                                Offer Accepted
                            @endif 
                        </div>
                    </div>
                    <div class="widget-content-right">
                        <div class="widget-numbers text-white"><span id="total-OfferAccepted"></span></div>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>








@if(Auth::user()->can('jobs.graph.data'))
    <!--Graph Start-->
    <div class="card">
        <h5 class="card-header">
            <div class="row">
                <div class="col-sm">
                    Applicants
                </div>
                <div class="col-sm text-end">
                    <select id="year" name="" class="form-control-sm">
                        @php $last= date('Y')-20 @endphp
                        @php $now = date('Y') @endphp
                            @for ($i = $now; $i >= $last; $i--)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                    </select>
                </div>
            </div>
        </h5>
        
            <div class="card-body" id="graph-container">
                <div class="loader" style="display:none"></div>
                <canvas id="myChart"  height="70"></canvas>
            </div>

    </div>
    <!--//Graph End-->
@endif
<!--Graph Start-->
<script>

function getCountData(filterValue)
{
    $(".loader").show();
    //ajax call for
    $.ajax({
            url: "{{route('get.count.data')}}", //get.count.data
            dataType: 'json',
            method: 'post',
            data: 
            {
                filterValue: filterValue
            },
            success: function(result)
            {
                $('#total-users').text(JSON.stringify(result.users));
                $('#total-candidates').text(JSON.stringify(result.candidates));
                $('#total-active-jobs').text(JSON.stringify(result.jobs));
                $('#total-applications').text(JSON.stringify(result.applicants));
                $('#total-Applied').text(JSON.stringify(result.Applied));
                $('#total-Hired').text(JSON.stringify(result.Hired));
                $('#total-InterviewCleared').text(JSON.stringify(result.InterviewCleared));
                $('#total-InterviewFailed').text(JSON.stringify(result.InterviewFailed));
                $('#total-InterviewNotScheduled').text(JSON.stringify(result.InterviewNotScheduled));
                $('#total-InterviewScheduled').text(JSON.stringify(result.InterviewScheduled));
                $('#total-NotAppeared').text(JSON.stringify(result.NotAppeared));
                $('#total-Notshortlisted').text(JSON.stringify(result.NotShortlisted));
                $('#total-OfferDeclined').text(JSON.stringify(result.OfferDeclined));
                $('#total-OnHold').text(JSON.stringify(result.OnHold));
                $('#total-Shortlisted').text(JSON.stringify(result.Shortlisted));
                $('#total-ScreeningPending').text(JSON.stringify(result.ScreeningPending));
                $('#total-InterviewToBeSchedule').text(JSON.stringify(result.InterviewToBeSchedule));
                $('#total-InternshipOffered').text(JSON.stringify(result.InternshipOffered));
                $('#total-OfferAccepted').text(JSON.stringify(result.OfferAccepted));
                
                $(".loader").hide();
            },
            error: function (data, textStatus, errorThrown) 
            {
                $(".loader").hide();
                console.log(JSON.stringify(data));
            }

        });

}

$(document).on('click', '.filters', function () {
    
    $('.filters').removeClass('btn-primary');
    $('.filters').addClass('btn-outline-primary');

    $(this).addClass('btn-primary');
    $(this).removeClass('btn-outline-primary');

    //get the value of button
    let filterValue = $(this).attr("data-value"); 
    
    getCountData(filterValue);


});

createGraph();
getCountData('');
$(document).on('change', '#year', function () {
    createGraph();
});

//widgetUrl

$(document).on('click', '.widgetUrl', function () {
    
    var filterValue ='';

    //get the value of url 
    let DataUrl = $(this).attr("data-url"); 
    
    var firstBtnPrimary = $(".filters.btn-primary").first();
    // Check if an element with the class "btn-primary" exists
    if (firstBtnPrimary.length > 0) {
        // Retrieve the "data-value" attribute
        var filterValue = firstBtnPrimary.data("value");
    }

     // Check if the URL already contains a question mark
     if (DataUrl.indexOf("?") === -1) {
            DataUrl += "?dashboard_filter="+ filterValue;
        } else {
            DataUrl += "&dashboard_filter=" + filterValue;
        }
    
    window.location.href = DataUrl;
    


});

function createGraph()
{
    var year = $('#year').val();
    if(year)
    {
        $(".loader").show();
        $('#myChart').html('');
        $('#myChart').remove(); // this is my <canvas> element
        $('#graph-container').append('<canvas id="myChart" height="70"><canvas>');
        $.ajaxSetup({
            headers: {
                //'X-CSRF-TOKEN': $("#_token").val()
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
                url: "{{route('jobs.graph.data')}}",
                dataType: 'json',
                method: 'post',
                data: 
                {
                    year: $('#year').val()
                },
                success: function(result)
                {
                    $(".loader").hide();
                    new Chart(document.getElementById("myChart"), {
                        type: 'bar',
                        data: {
                            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                            datasets: result
                        },
                        options: {
                            scales: {
                                yAxes: [{
                                    ticks: {
                                        beginAtZero: true
                                    }
                                }]
                            },
                            title: {
                            display: true,
                            text: year+' Report'
                            }
                        }
                    });
                    
                },
                error: function (data, textStatus, errorThrown) 
                {
                    $(".loader").hide();
                    console.log(JSON.stringify(data));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
                    
                    
                
            });
    }        

}
    
</script>
<!--//Graph End-->



@endsection
