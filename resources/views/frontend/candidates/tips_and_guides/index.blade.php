@extends('frontend.layouts.app-master')
@section('title', 'Tips and Guides')
@section('content')
<style>
.card img {
    margin-left: -13px !important;
    margin-top: -7px !important;;
}
</style>

<div class="mb-2">
    <div class="card">
        <div class="card-header">{{Arr::get($tipAndGuideRow, 'title')}}</div>
        <div class="card-body">
            {!! Arr::get($tipAndGuideRow, 'content') !!}
            </div>
        </div>
</div>    



    
    @if(!empty($tipsAndGuides))
        
        @php $counter=0;@endphp
        
        <div class="row mb-2">

            @foreach($tipsAndGuides as $row)
            <div class="col-sm-4">
                <div class="card">
                <div class="card-header">{{Arr::get($row, 'title')}}</div>
                <div class="card-body text-start">
                
                    <div class="card-text">{!! Arr::get($row, 'summary') !!}</div>
                    
                    <a class="btn btn-primary btn-sm" href="{{ route('tips-and-guides.index', Arr::get($row, 'slug')) }}" >Learn More</a>
                </div>
                </div>
            </div>
                
                @php $counter++; @endphp

                
                @if($counter %3==0)
                    @if($counter != count($tipsAndGuides))
                        </div>
                        <div class="row mb-2">
                    @endif
                @endif
                
            
            @endforeach
        
        </div>
    @endif








@endsection