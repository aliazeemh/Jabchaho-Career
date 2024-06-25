@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Show Job Benefit</h2>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <div>
                Name: {{ Arr::get($jobBenefit, 'name')}}
            </div>
            
            <div>
                Enable: {{ $booleanOptions[Arr::get($jobBenefit, 'is_enabled')] }}
            </div>
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('job_benefits.edit', $jobBenefit->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('job_benefits.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
