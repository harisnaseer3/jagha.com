<div class="row">
    <div class="col-12">
        <div class="pull-right">
            <strong>Sort Alphabetically</strong>
            <label class="switch">
                <input name="alpha-partners-switch" id="alpha-partners-switch" type="checkbox" {{$sort}}>
                <span class="slider round"></span>
            </label>

        </div>
    </div>
</div>
<h5 style="font-weight: 400">Featured Partners</h5>
<div class="s-border"></div>
<div class="m-border"></div>
<div class="row  mb-3">
    @foreach($featured_agencies as $agency)
        <div class="col-sm-3 my-2">
            <a href="{{route('city.wise.partners',['agency'=>'featured','city'=> strtolower(Str::slug($agency->city)),'sort'=> 'newest'])}}"
               title="agencies in {{$agency->city}}"
               class="breadcrumb-link">
                {{$agency->city}} ({{$agency->agency_count}})
            </a>
        </div>
    @endforeach
</div>
<h5 style="font-weight: 400">Key Partners</h5>
<div class="s-border"></div>
<div class="m-border"></div>
<div class="row mb-3">
    @foreach($key_agencies as $agency)
        <div class="col-sm-3 my-2">
            <a href="{{route('city.wise.partners',['agency'=>'key','city'=> strtolower(Str::slug($agency->city)),'sort'=> 'newest'])}}"
               title="agencies in {{$agency->city}}"
               class="breadcrumb-link">
                {{$agency->city}} ({{$agency->agency_count}})
            </a>
        </div>
    @endforeach
</div>
<h5 style="font-weight: 400">Other Partners</h5>
<div class="s-border"></div>
<div class="m-border"></div>
<div class="row">
    @foreach($normal_agencies as $agency)
        <div class="col-sm-3 my-2">
            <a href="{{route('city.wise.partners',['agency'=>'other','city'=> strtolower(Str::slug($agency->city)),'sort'=> 'newest'])}}"
               title="agencies in {{$agency->city}}"
               class="breadcrumb-link">
                {{$agency->city}} ({{$agency->agency_count}})
            </a>
        </div>
    @endforeach
</div>
