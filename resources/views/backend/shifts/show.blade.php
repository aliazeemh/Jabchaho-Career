@extends('backend.layouts.app-master')

@section('content')
    <div class="bg-light p-4 rounded">
        <h2>Show Shift</h2>
        <div class="lead">
            
        </div>
        
        <div class="container mt-4">
            <div>
                Name: {{ Arr::get($shift, 'name')}}
            </div>
            <div>
                From: {{ date('g:i A',strtotime(Arr::get($shift, 'from'))) }}
            </div>
            <div>
                To: {{ date('g:i A',strtotime(Arr::get($shift, 'to'))) }}
            </div>
            <div>
                Enable: {{ $booleanOptions[Arr::get($shift, 'is_enabled')] }}
            </div>
        </div>

    </div>
    <div class="mt-4">
        <a href="{{ route('shifts.edit', $shift->id) }}" class="btn btn-info">Edit</a>
        <a href="{{ route('shifts.index') }}" class="btn btn-default">Back</a>
    </div>
@endsection
