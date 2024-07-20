@extends('frontend.layouts.auth-master')
@section('title', 'Home')
@section('content')
<script>
    var positionConf = {};
    var imgConf = {};
    @php $counter=0;@endphp
    @if(!empty($areaOfInterestGroups))
        @foreach($areaOfInterestGroups as $row)    
            positionConf[{{Arr::get($row, 'id')}}] = {{Arr::get($jobsCountViaAreaOfInterestGroups, Arr::get($row, 'id'),0)}};
            imgConf[{{Arr::get($row, 'id')}}] = "{{asset("assets/images/icons/home/0")}}@php echo $counter++; @endphp.png";
        @endforeach
    @endif

</script>
<div class="container">
    
    <!--Search Section-->
    @include('frontend.jobs.partials.search')
    <!--//Search Section-->




    <!--Categories Section-->
    @if(!empty($areaOfInterestGroups))
        <div id="myCarousel" class="carousel slide" data-ride="carousel" data-interval="0">
            <!-- Wrapper for carousel items -->
                <div class="carousel-inner">
                    
                </div>

            @if(count($areaOfInterestGroups)>6)
                <!-- Carousel controls -->
            <a class="carousel-control-prev" href="#myCarousel" data-slide="prev">
                <i class="fa fa-angle-left"></i>
            </a>
            <a class="carousel-control-next" href="#myCarousel" data-slide="next">
                <i class="fa fa-angle-right"></i>
            </a>
            @endif
        </div>
    @endif 
    <!--//Categories Section-->
    <div class="future-opportunities"><span class="tc-dark">FOR FUTURE OPPORTUNITIES </span> <a class="sign-up" href="{{ route('signup.show') }}">SIGN UP</a></div>

</div>
<script type="text/javascript">
    var carouselConf = @php echo $areaOfInterestGroups; @endphp;
    carouselConf = carouselConf.map(conf => {
        conf.position = positionConf[conf.id];
        conf.img = imgConf[conf.id];
        return conf;
    });
    
    var carouselTemp = {
        row: '<div class="item carousel-item {isActive}"> \
                <div class="row"> \
                    {template} \
                </div>\
              </div>',
        item: '<div class="col-sm mydivouter"> \
                    <img class="card-img" src="{img}"/>\
                    <p class="card-text tc-yelllow t-uppercase"><a href="{{route("jobs.list")}}?title=&city=&category={id}&jobType=" class="tc-yelllow t-uppercase job-link" >{name}</a></p> \
                    <p class="card-text">{position}</p>\
             </div>'
        }
    var renderedTemplate = "";
    var items = "";
    var isFirstCarousel = true;
    for (let index = 1; index <= carouselConf.length; index++) {
        let cConf = carouselConf[index-1];
        if(window.innerWidth>1024)
        {
            items += carouselTemp.item.replace("{img}",cConf.img).replace("{id}",cConf.id).replace("{name}",cConf.name).replace("{position}",cConf.position>1?"( "+cConf.position+" open positions )":"( "+cConf.position+" open position )")
            if((index>1 && index%6==0)||(index==carouselConf.length && index%6!=0))
            {
                renderedTemplate += carouselTemp.row.replace("{template}",items).replace("{isActive}", isFirstCarousel?"active":"");
                items = "";
                isFirstCarousel = false;
            }
        }
        else if(window.innerWidth>500)
        {
            items += carouselTemp.item.replace("{img}",cConf.img).replace("{id}",cConf.id).replace("{name}",cConf.name).replace("{position}",cConf.position>1?"( "+cConf.position+" open positions )":"( "+cConf.position+" open position )")
            if((index>1 && index%4==0)||(index==carouselConf.length && index%4!=0))
            {
                renderedTemplate += carouselTemp.row.replace("{template}",items).replace("{isActive}", isFirstCarousel?"active":"");
                items = "";
                isFirstCarousel = false;
            }
        }
        else
        {
            items += carouselTemp.item.replace("{img}",cConf.img).replace("{id}",cConf.id).replace("{name}",cConf.name).replace("{position}",cConf.position>1?"( "+cConf.position+" open positions )":"( "+cConf.position+" open position )")
            if((index>0 && index%2==0)||(index==carouselConf.length && index%2!=0))
            {
                renderedTemplate += carouselTemp.row.replace("{template}",items).replace("{isActive}", isFirstCarousel?"active":"");
                items = "";
                isFirstCarousel = false;
            }
        }
        
    }
    document.querySelector("#myCarousel .carousel-inner").innerHTML = renderedTemplate;
</script>
@endsection