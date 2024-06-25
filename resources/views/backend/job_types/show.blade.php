@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Show Job Type</h2>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <div>
                Name: {{ Arr::get($jobType, 'name')}}
            </div>
            
            <div>
                Enable: {{ $booleanOptions[Arr::get($jobType, 'is_enabled')] }}
            </div>
            <div>
            Default Checked: {{ $booleanOptions[Arr::get($jobType, 'is_checked')] }}
            </div>
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('job_types.edit', $jobType->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('job_types.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
