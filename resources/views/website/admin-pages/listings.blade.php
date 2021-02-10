@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>About Pakistan Properties by https://www.aboutpakistan.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}" async derfer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
    <style>


    </style>

@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
            @include('website.admin-pages.includes.admin-nav')
            <div style="min-height:90px"></div>
            <div class="submit-property">
                <div class="container-fluid container-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content" id="ListingsTabContent">
                                <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                                    <div class="row my-4">
                                        <div class="col-md-3">
                                            @include('website.admin-pages.includes.sidebar')
                                        </div>
                                        <div class="col-md-9">
                                            @include('website.layouts.flash-message')
                                            <div class="tab-content" id="listings-tabContent">
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                                        {{ Form::open(['route' => ['admin.property.search.city'], 'method' => 'post', 'role' => 'form','class'=>'color-555', 'id'=>'search-property-city']) }}
                                                        <div class="row">
                                                            <div class="col-10 pr-0 mr-0">
                                                                <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible city-select2 select2-single" id="search2-city"
                                                                        style="width: 100%; border: 0" tabindex="-1"
                                                                        aria-hidden="true" aria-describedby="city-error" aria-invalid="false" name="city" required>
                                                                    <option value selected disabled data-index="0">Select city</option>
                                                                    @foreach(['islamabad' => 'Islamabad', 'karachi' => 'Karachi', 'lahore' => 'Lahore', 'rawalpindi' => 'Rawalpindi', 'abbottabad' => 'Abbottabad', 'abdul_hakim' => 'Abdul Hakim', 'ahmedpur east' => 'Ahmedpur East', 'alipur' => 'Alipur', 'arifwala' => 'Arifwala', 'astore' => 'Astore', 'attock' => 'Attock', 'awaran' => 'Awaran', 'badin' => 'Badin', 'bagh' => 'Bagh', 'bahawalnagar' => 'Bahawalnagar', 'bahawalpur' => 'Bahawalpur', 'balakot' => 'Balakot', 'bannu' => 'Bannu', 'barnala' => 'Barnala', 'batkhela' => 'Batkhela', 'bhakkar' => 'Bhakkar', 'bhalwal' => 'Bhalwal', 'bhimber' => 'Bhimber', 'buner' => 'Buner', 'burewala' => 'Burewala', 'chaghi' => 'Chaghi', 'chakwal' => 'Chakwal', 'charsadda' => 'Charsadda', 'chichawatni' => 'Chichawatni', 'chiniot' => 'Chiniot', 'chishtian sharif' => 'Chishtian Sharif', 'chitral' => 'Chitral', 'choa_saidan_shah' => 'Choa Saidan Shah', 'chunian' => 'Chunian', 'dadu' => 'Dadu', 'daharki' => 'Daharki', 'daska' => 'Daska', 'daur' => 'Daur', 'depalpur' => 'Depalpur', 'dera_ghazi_khan' => 'Dera Ghazi Khan', 'dera_ismail_khan' => 'Dera Ismail Khan', 'dijkot' => 'Dijkot', 'dina' => 'Dina', 'dobian' => 'Dobian', 'duniya_pur' => 'Duniya Pur', 'fata' => 'FATA', 'faisalabad' => 'Faisalabad', 'fateh_jang' => 'Fateh Jang', 'gaarho' => 'Gaarho', 'gadoon' => 'Gadoon', 'galyat' => 'Galyat', 'ghakhar' => 'Ghakhar', 'gharo' => 'Gharo', 'ghotki' => 'Ghotki', 'gilgit' => 'Gilgit', 'gojra' => 'Gojra', 'gujar_khan' => 'Gujar Khan', 'gujranwala' => 'Gujranwala', 'gujrat' => 'Gujrat', 'gwadar' => 'Gwadar', 'hafizabad' => 'Hafizabad', 'hala' => 'Hala', 'hangu' => 'Hangu', 'harappa' => 'Harappa', 'haripur' => 'Haripur', 'haroonabad' => 'Haroonabad', 'hasilpur' => 'Hasilpur', 'hassan_abdal' => 'Hassan Abdal', 'haveli_lakha' => 'Haveli Lakha', 'hazro' => 'Hazro', 'hub_chowki' => 'Hub Chowki', 'hujra_shah_muqeem' => 'Hujra Shah Muqeem', 'hunza' => 'Hunza', 'hyderabad' => 'Hyderabad', 'islamabad' => 'Islamabad', 'jacobabad' => 'Jacobabad', 'jahanian' => 'Jahanian', 'jalalpur_jattan' => 'Jalalpur Jattan', 'jampur' => 'Jampur', 'jamshoro' => 'Jamshoro', 'jatoi' => 'Jatoi', 'jauharabad' => 'Jauharabad', 'jhang' => 'Jhang', 'jhelum' => 'Jhelum', 'kaghan' => 'Kaghan', 'kahror_pakka' => 'Kahror Pakka', 'kalat' => 'Kalat', 'kamalia' => 'Kamalia', 'kamoki' => 'Kamoki', 'kandiaro' => 'Kandiaro', 'karachi' => 'Karachi', 'karak' => 'Karak', 'kasur' => 'Kasur', 'khairpur' => 'Khairpur', 'khanewal' => 'Khanewal', 'khanpur' => 'Khanpur', 'kharian' => 'Kharian', 'khipro' => 'Khipro', 'khushab' => 'Khushab', 'khuzdar' => 'Khuzdar', 'kohat' => 'Kohat', 'kot_addu' => 'Kot Addu', 'kotli' => 'Kotli', 'kotri' => 'Kotri', 'lahore' => 'Lahore', 'lakki_marwat' => 'Lakki Marwat', 'lalamusa' => 'Lalamusa', 'larkana' => 'Larkana', 'lasbela' => 'Lasbela', 'layyah' => 'Layyah', 'liaquatpur' => 'Liaquatpur', 'lodhran' => 'Lodhran', 'loralai' => 'Loralai', 'lower_dir' => 'Lower Dir', 'mailsi' => 'Mailsi', 'makran' => 'Makran', 'malakand' => 'Malakand', 'mandi_bahauddin' => 'Mandi Bahauddin', 'mangla' => 'Mangla', 'mansehra' => 'Mansehra', 'mardan' => 'Mardan', 'matiari' => 'Matiari', 'matli' => 'Matli', 'mian_channu' => 'Mian Channu', 'mianwali' => 'Mianwali', 'mingora' => 'Mingora', 'mirpur' => 'Mirpur', 'mirpur_khas' => 'Mirpur Khas', 'mirpur_sakro' => 'Mirpur Sakro', 'mitha_tiwana' => 'Mitha Tiwana', 'moro' => 'Moro',
                                                                                       'multan' => 'Multan', 'muridke' => 'Muridke', 'murree' => 'Murree', 'muzaffarabad' => 'Muzaffarabad', 'muzaffargarh' => 'Muzaffargarh', 'nankana_sahib' => 'Nankana Sahib', 'naran' => 'Naran', 'narowal' => 'Narowal', 'nasar_ullah_khan_town' => 'Nasar Ullah Khan Town', 'nasirabad' => 'Nasirabad', 'naushahro_feroze' => 'Naushahro Feroze', 'nawabshah' => 'Nawabshah', 'neelum' => 'Neelum', 'new_mirpur_city' => 'New Mirpur City', 'nowshera' => 'Nowshera', 'okara' => 'Okara', 'others' => 'Others', 'others_azad kashmir' => 'Others Azad Kashmir', 'others_balochistan' => 'Others Balochistan', 'others_gilgit baltistan' => 'Others Gilgit Baltistan', 'others_khyber pakhtunkhwa' => 'Others Khyber Pakhtunkhwa', 'others_punjab' => 'Others Punjab', 'others_sindh' => 'Others Sindh', 'pakpattan' => 'Pakpattan', 'peshawar' => 'Peshawar', 'pind_dadan_khan' => 'Pind Dadan Khan', 'pindi_bhattian' => 'Pindi Bhattian', 'pir_mahal' => 'Pir Mahal', 'qazi_ahmed' => 'Qazi Ahmed', 'quetta' => 'Quetta', 'rahim_yar_khan' => 'Rahim Yar Khan', 'rajana' => 'Rajana', 'rajanpur' => 'Rajanpur', 'ratwal' => 'Ratwal', 'rawalkot' => 'Rawalkot', 'rawalpindi' => 'Rawalpindi', 'rohri' => 'Rohri', 'sadiqabad' => 'Sadiqabad', 'sahiwal' => 'Sahiwal', 'sakrand' => 'Sakrand', 'samundri' => 'Samundri', 'sanghar' => 'Sanghar', 'sarai_alamgir' => 'Sarai Alamgir', 'sargodha' => 'Sargodha', 'sehwan' => 'Sehwan', 'shabqadar' => 'Shabqadar', 'shahdadpur' => 'Shahdadpur', 'shahkot' => 'Shahkot', 'shahpur_chakar' => 'Shahpur Chakar', 'shakargarh' => 'Shakargarh', 'shehr_sultan' => 'Shehr Sultan', 'sheikhupura' => 'Sheikhupura', 'sher_garh' => 'Sher Garh', 'shikarpur' => 'Shikarpur', 'shorkot' => 'Shorkot', 'sialkot' => 'Sialkot', 'sibi' => 'Sibi', 'skardu' => 'Skardu', 'sudhnoti' => 'Sudhnoti', 'sujawal' => 'Sujawal', 'sukkur' => 'Sukkur', 'swabi' => 'Swabi', 'swat' => 'Swat', 'talagang' => 'Talagang', 'tando_adam' => 'Tando Adam', 'tando_allahyar' => 'Tando Allahyar', 'tando_bago' => 'Tando Bago', 'tando_muhammad_khan' => 'Tando Muhammad Khan', 'taxila' => 'Taxila', 'tharparkar' => 'Tharparkar', 'thatta' => 'Thatta', 'toba_tek_singh' => 'Toba Tek Singh', 'turbat' => 'Turbat', 'vehari' => 'Vehari', 'wah' => 'Wah',
                                                                                        'wazirabad' => 'Wazirabad', 'waziristan' => 'Waziristan', 'yazman' => 'Yazman', 'zhob' => 'Zhob'] as $city)
                                                                        <option value="{{ $city }}" {{str_replace('-',' ',request()->city) == $city ? 'selected':''}}
                                                                        data-index={{ $city === 'Islamabad' ? '0' : '' }}>
                                                                            {{ $city}}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-2 px-0 mx-0">
                                                                <button class="btn btn-primary search-submit-btn btn-sm" type="Submit"><i class="fa fa-search ml-1"></i></button>
                                                            </div>
                                                        </div>
                                                        {{ Form::close() }}
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12 mb-3">
                                                        {{ Form::open(['route' => ['admin.property.search.id'], 'method' => 'post', 'role' => 'form' ,'id'=>'search-property-ref']) }}
                                                        <div class="row">
                                                            <div class="col-10 pr-0 mr-0">
                                                                <input class="form-control form-control-sm" type="text" placeholder="Property ID" name="property_id"
                                                                       autocomplete="false" required>
                                                            </div>
                                                            <div class="col-2 px-0 mx-0">
                                                                <button class="btn btn-primary search-submit-btn btn-sm" type="Submit"><i class="fa fa-search ml-1"></i></button>
                                                            </div>
                                                        </div>
                                                        {{ Form::close() }}
                                                    </div>
                                                    <div class="col-xl-4 col-lg-4 col-md-4 col-sm-12">
                                                        <div class="row">
                                                            <div class="col-xl-2 col-lg-3 col-md-4 col-sm-12 my-auto mb-sm-2">
                                                                <strong class="font-14 ">Sort By</strong>
                                                            </div>


                                                            <div class="col-xl-10 col-lg-9 col-md-8 col-sm-10">
                                                                <select class="w-100 sorting" style="width: 100%">
                                                                    <option value selected disabled data-index="0">Select Sorting Option</option>
                                                                    <option value="oldest" {{ $params['order'] === 'asc' || request()->query('sort') === 'oldest'  ? 'selected' : '' }}>Oldest
                                                                    </option>
                                                                    <option value="newest" {{ $params['order'] === 'desc' || request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest
                                                                    </option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                @foreach(['all', 'sale', 'rent','wanted','basic','bronze','silver','golden','platinum'] as $option)
                                                    <div class="tab-pane fade show {{\Illuminate\Support\Facades\Request::segments()[5] === $option? 'active' : '' }}" id="listings-{{$option}}"
                                                         role="tabpanel" aria-labelledby="listings-{{$option}}-tab">
                                                        <h6>{{ucwords($option)}} Listings</h6>
                                                        <div class="my-4">
                                                            <div class="table-responsive">
                                                                {{--                                                        <table class="table table-sm table-bordered">--}}
                                                                {{--                                                        <table class="property-listing {{\Illuminate\Support\Facades\Request::segments()[5] === $option? 'display' : '' }}" style="width: 100%">--}}
                                                                <table class="table table-sm table-bordered">
                                                                    <thead class="theme-blue text-white">
                                                                    <tr>
                                                                        <td>ID</td>
                                                                        <td>Type</td>
                                                                        @if($option === 'all')
                                                                            <td> Purpose</td>
                                                                        @endif
                                                                        <td>Location</td>
                                                                        <td>Price (PKR)</td>
                                                                        <td>Added By</td>
                                                                        <td>Contact Person</td>
                                                                        <td>Contact #</td>
                                                                        <td>Listed For</td>
                                                                        <td>Listed Date</td>

                                                                        @if($params['status'] == 'active')
                                                                            <td>Activation Date</td>
                                                                            <td>Activated By</td>
                                                                            {{--                                                                            <td>Boost</td>--}}
                                                                        @endif
                                                                        @if($params['status'] == 'rejected')
                                                                            <td>Rejected By</td>
                                                                        @elseif($params['status'] == 'deleted')
                                                                            <td>Deleted By</td>
                                                                        @endif
                                                                        <td>Status Controls</td>
                                                                        <td>Controls</td>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>

                                                                    @if($listings[$option] !== null)
                                                                        @forelse($listings[$option] as $all_listing)
                                                                            <tr>
                                                                                <td>{{ $all_listing->id }}</td>
                                                                                @if($option === 'all')
                                                                                    <td>{{ $all_listing->purpose}}</td>
                                                                                @endif
                                                                                <td>{{ $all_listing->type }}</td>
                                                                                <td>{{ $all_listing->location }}, {{$all_listing->city}}</td>
                                                                                @if($all_listing->price != '0')
                                                                                    <td class="text-right pr-3">{{  $all_listing->price}}</td>
                                                                                @else
                                                                                    <td class="pr-3">{{ 'Call option selected for price'}}</td>
                                                                                @endif
                                                                                <td>{{\App\Models\Dashboard\User::getUserName($all_listing->user_id)}}</td>
                                                                                <td>{{$all_listing->contact_person}}</td>
                                                                                <td>{{$all_listing->cell}}</td>
                                                                                <td>{{$all_listing->agency_id == null ? 'Individual':'Agency ('.\App\Models\Agency::getAgencyTitle($all_listing->agency_id) .')'}}</td>

                                                                                {{--                                                                                <td>{{ (new \Illuminate\Support\Carbon($all_listing->listed_date))->isoFormat('MMMM Do YYYY, h:mm:ss a') }}</td>--}}
                                                                                <td>{{ (new \Illuminate\Support\Carbon($all_listing->created_at))->isoFormat('DD-MM-YYYY  h:mm a') }}</td>
                                                                                @if($params['status'] == 'active')
                                                                                    <td>
                                                                                        <div>
                                                                                            {{ (new \Illuminate\Support\Carbon($all_listing->activated_at))->isoFormat('DD-MM-YYYY  h:mm a') }}
                                                                                        </div>
                                                                                        <div class="badge badge-success p-2">
                                                                                            <strong class="color-white font-12"> Expires
                                                                                                in {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffInDays(new \Illuminate\Support\Carbon(now()))}}
                                                                                                days </strong>
                                                                                        </div>
                                                                                    </td>
                                                                                    <td>@if(isset($all_listing->reviewed_by)) {{ucwords($all_listing->reviewed_by)}}@endif</td>
                                                                                    {{--                                                                                    <td>--}}
                                                                                    {{--                                                                                        <span>Boost Count : 0</span>--}}
                                                                                    {{--                                                                                        <a href="javascript:void(0)" class="btn btn-sm btn-success pull-right disabled">Click to Boost</a>--}}
                                                                                    {{--                                                                                    </td>--}}
                                                                                @endif
                                                                                @if($params['status'] == 'rejected' || $params['status'] == 'deleted' )
                                                                                    <td>@if(isset($all_listing->reviewed_by)) {{ucwords($all_listing->reviewed_by)}}@endif</td>
                                                                                @endif
                                                                                <td>
                                                                                    @if($params['status'] == 'deleted')
                                                                                        <div class="rejected-status"><strong>Deleted</strong></div>
                                                                                    @elseif($params['status'] == 'edited')
                                                                                        <div class="pending-status"><strong>Edit</strong></div>
                                                                                    @elseif($params['status'] === 'sold')
                                                                                        <div class="sold-status"><strong>Property Sold</strong></div>
                                                                                    @elseif($params['status'] === 'pending')
                                                                                        <div class="pending-status"><strong>Pending</strong></div>
                                                                                    @elseif($params['status'] === 'rejected')
                                                                                        <div class="rejected-status"><strong>Rejected</strong></div>
                                                                                    @else
                                                                                        <form>
                                                                                            @if($params['status'] == 'active')
                                                                                                <input type="radio" name="status" value="active"
                                                                                                       {{$all_listing->status === 'active'? 'checked':'' }}
                                                                                                       data-id="{{ $all_listing->id }}">
                                                                                                <label for="active">Active</label>
                                                                                            @endif
                                                                                            @if($params['status'] != 'active')
                                                                                                <input type="radio" name="status" value="reactive"
                                                                                                       {{$all_listing->status === 'active'? 'disabled':'' }}
                                                                                                       data-id="{{ $all_listing->id }}">
                                                                                                <label for="active">Active</label>
                                                                                            @endif
                                                                                            @if($params['status'] != 'expired')
                                                                                                <input type="radio" name="status" value="expired"
                                                                                                       {{$all_listing->status === 'expired'? 'checked':'' }}
                                                                                                       {{$all_listing->status === 'edited'? 'disabled':'' }}
                                                                                                       {{$all_listing->status === 'sold'? 'checked':'' }}
                                                                                                       data-id="{{ $all_listing->id }}" {{$all_listing->status === 'expired'? 'checked':'' }}>
                                                                                                <label for="expired">Expired</label>
                                                                                            @endif
                                                                                            @if($params['status'] != 'sold' && $all_listing->purpose != 'Wanted')
                                                                                                <input type="radio" name="status" value="sold"
                                                                                                       data-id="{{ $all_listing->id }}" {{$all_listing->status === 'sold'? 'checked':'' }}{{$all_listing->status === 'edited'? 'disabled':'' }}>
                                                                                                <label for="sold">Sold</label>
                                                                                            @endif
                                                                                        </form>
                                                                                    @endif
                                                                                </td>
                                                                                <td>
                                                                                    @if($params['status'] == 'active')
                                                                                        <a type="button" target="_blank" href="{{$all_listing->property_detail_path()}}"
                                                                                           class="btn btn-sm btn-primary mb-1"
                                                                                           data-toggle-1="tooltip"
                                                                                           data-placement="bottom" title="View Property">
                                                                                            <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                                        </a>
                                                                                    @endif
                                                                                    @if($params['status'] === 'pending')
                                                                                        <a type="button" href="{{route('admin-properties-edit', $all_listing->id)}}"
                                                                                           class="btn btn-sm btn-info mb-1
                                                                                            {{$params['status'] == 'deleted' ? 'anchor-disable':'' }}
                                                                                           {{$params['status'] == 'sold' ? 'anchor-disable':'' }}"
                                                                                           data-toggle-1="tooltip"
                                                                                           data-placement="bottom" title="Verify and Activate Property">
                                                                                            Verify & Activate
                                                                                            <span class="sr-only sr-only-focusable" aria-hidden="true">Verify and Activate</span>
                                                                                        </a>
                                                                                    @elseif($params['status'] != 'deleted')
                                                                                        {{--                                                                                        @if($params['status'] != 'sold')--}}
                                                                                        <a type="button" href="{{route('admin-properties-edit', $all_listing->id)}}"
                                                                                           class="btn btn-sm btn-warning mb-1"
                                                                                           data-toggle-1="tooltip" data-placement="bottom" title="Edit Property">
                                                                                            <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                                        </a>
                                                                                        {{--                                                                                        @endif--}}
                                                                                        <a type="button" class="btn btn-sm btn-danger mb-1"
                                                                                           data-toggle-1="tooltip" data-placement="bottom" title="Delete Property" data-toggle="modal"
                                                                                           data-target="#delete"
                                                                                           data-record-id="{{$all_listing->id}}">
                                                                                            <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                                        </a>
                                                                                    @elseif($params['status'] == 'deleted')
                                                                                        <a type="button" href="{{route('admin-properties-edit', $all_listing->id)}}"
                                                                                           class="btn btn-sm btn-warning mb-1 {{$params['status'] == 'sold' ? 'anchor-disable':'' }}"
                                                                                           data-toggle-1="tooltip" data-placement="bottom" title="Restore Property">
                                                                                            Review & Restore<span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                                        </a>
                                                                                    @endif
                                                                                </td>
                                                                            </tr>
                                                                        @empty
                                                                            <tr>
                                                                                <td colspan="10" class="p-4 text-center">No Listings Found!</td>
                                                                            </tr>
                                                                        @endforelse
                                                                    @endif
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                            @if($params['status'] === 'edited')
                                                                <div class="font-12 mb-2"><span class="color-red">*</span> Please check reactive button for verification of changes</div>
                                                            @elseif([$params['status'] === 'active'] ||[$params['status'] === 'expired'] )
                                                                <div class="font-12 mb-2"><span class="color-red">*</span> If property is expired, it will not display on the main site</div>
                                                            @endif
                                                            @if($listings[$option] != null)
                                                                {{--                                                                {{ $listings[$option]->links() }}--}}
                                                                {{ $listings[$option]->links('vendor.pagination.bootstrap-4') }}
                                                            @endif
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('website.admin-pages.layouts.delete-modal', array('route'=>'properties'))
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/admin-listings-page.js')}}" defer></script>
    <script>
        (function ($) {
            $(document).ready(function () {
                $('.select2').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
                });
                $('.select2bs4').select2({
                    language: '{{app()->getLocale()}}',
                    direction: '{{app()->getLocale() === "en" ? "ltr" : "rtl"}}',
                    theme: 'bootstrap4',
                });
                $('select').select2({
                    placeholder: 'Select City',
                    allowClear: true
                });
                $('.sorting').on('change', function (e) {
                    if ($(this).val() !== null) {
                        let sort = '';
                        if ($(this).val() === 'newest') {
                            sort = 'order/desc/';
                        } else if ($(this).val() === 'oldest') {
                            sort = 'order/asc/';
                        }
                        let link = window.location.href
                        let break_link = link.split('order/');
                        let piece_1 = break_link[0];
                        let piece_2 = break_link[1];
                        let link_2 = piece_2.split('sc/')[1];
                        window.location = piece_1 + sort + link_2;
                    }
                });
            });
        })(jQuery);
    </script>
@endsection
