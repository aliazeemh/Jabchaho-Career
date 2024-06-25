@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Show Referred Candidate</h2> 
        <div class="container mt-4">
            <div>
                    <strong>Candidate Full Name:</strong> {{ Arr::get($refercandidate, 'candidate_full_name')}}
            </div>

            <div>
                    <strong>Job Category:</strong> {{ Arr::get($jobType, 'name')}}
            </div>

            <div>
                    <strong>Area Of Interest:</strong> {{ Arr::get($areaOfInterestOption, 'name')}}
            </div>

            <div>
                    <strong>Mobile Number:</strong> {{ Arr::get($refercandidate, 'mobile')}}
            </div>

            <div>
                    <strong>City/Region:</strong> {{ Arr::get($refercandidate, 'city_region')}}
            </div>

            <div>
                    <strong>Education Level:</strong> {{ $levelOfEducation }} 
            </div>

            <div>
                    <strong>Candidate Email:</strong> {{ Arr::get($refercandidate, 'email')}}
            </div>

            <div>
                    <strong>Job Seeking Country:</strong> {{ $country }}
            </div>

            <div>
                    <strong>Previous Experience:</strong> {{ $previousExperience }}
            </div>

            <div>
                    <strong>AX Code:</strong> {{ Arr::get($refercandidate, 'ax_code')}}
            </div>

            
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('candidates.referred.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
