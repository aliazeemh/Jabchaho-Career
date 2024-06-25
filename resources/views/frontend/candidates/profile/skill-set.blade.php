@extends('frontend.layouts.app-profile')
@section('title', 'Skill Set')
@section('content')

<link href="{!! url('assets/css/select2.min.css') !!}" rel="stylesheet">

<div class="card-title"><img src="{{asset('assets/images/banners/skillset.jpg')}}" ></div>

<form class="form-horizontal" method="post" action="{{ route('skillset.perform') }}" autocomplete="off">
    <input type="hidden" name="_token" value="{{ csrf_token() }}" />

    <div><hr class="bg-danger border-2 border-top border-danger">Add your Skills or Expertise</div>

    <div class="row mb-3">
        <div class="col-sm-12">
                <select class="form-control form-control tokenizationSelect2" multiple="true" name="name[]">
                @if(!empty($skillSets) )
                        @foreach($skillSets as $row)
                                <option value="{{Arr::get($row->skillSet, 'name')}}" selected="selected">{{Arr::get($row->skillSet, 'name')}}</option>
                        @endforeach
                @endif                    
                </select>
                @if($errors->has('name.*'))
              <div class="text-danger">{{ $errors->first('name.*') }}</div>
            @endif
        </div>
    </div>


    <hr class="bg-danger border-2 border-top border-danger">
    <div class="row mb-3">
                <div class="col-sm-10 offset-sm-2">
                    <div class="text-end">
                        <button type="submit" class="btn btn-primary" value="Save & Continue">Save & Continue</button>  
                    </div>
                </div>
            </div>

</form>

<script src="{!! url('assets/js/select2.min.js') !!}"></script>
<script>
$(document).ready(function(){
//   $(".tokenizationSelect2").select2({
// 		tags: true,
// 		tokenSeparators: ['/',',',';'," "],
// 	});

$('.tokenizationSelect2').select2({
        //placeholder: 'Select Skill Set',
        tags: true,
 		//tokenSeparators: ['/',',',';'," "],
         tokenSeparators: [','],
         minimumInputLength: 2, // only start searching when the user has input 2 or more characters
         maximumInputLength:200,
        ajax: {
            url: "{{route('skillset.search')}}",
            dataType: 'json',
            delay: 250,
            processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.name,
                            id: item.name //save name b/c user can also add some tage
                        }
                    })
                };
            },
            cache: true
        }
    });

})
</script>        

@endsection