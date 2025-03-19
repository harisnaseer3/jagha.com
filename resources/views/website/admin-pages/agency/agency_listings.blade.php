@extends('website.layouts.app')
@php $current_route_name = \Illuminate\Support\Facades\Route::currentRouteName(); @endphp
@section('title')
    <title>Hr Jagha https://www.jagha.com</title>
@endsection
@section('css_library')
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom-dashboard-style.css')}}" async defer>
    <link rel="stylesheet" type="text/css" href="{{asset('website/css/custom.min.css')}}" async defer>
@endsection

@section('content')
    <div id="site" class="left relative">
        <div id="site-wrap" class="left relative">
        @include('website.admin-pages.includes.admin-nav')
        <!-- Top header start -->
            <div style="min-height:90px"></div>

            <!-- Submit Property start -->
            <div class="submit-property">
                <div class="container-fluid container-padding">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content" id="ListingsTabContent">
                                <div class="tab-pane fade show active" id="property_management" role="tabpanel" aria-labelledby="property_management-tab">
                                    <div class="row my-4">
                                        <div class="col-md-3">
                                            @include('website.admin-pages.agency.sidebar')
                                        </div>
                                        <div class="col-md-9">
                                            {{--                                    @include('website.layouts.user_notification')--}}
                                            @include('website.layouts.flash-message')
                                            <div class="tab-content" id="listings-tabContent">
                                                <div class="row mb-3 mt-3">
                                                    <div class="col-md-4 col-sm-12 mb-2">
                                                        {{ Form::open(['route' => ['admin.agency.search.city'], 'method' => 'post', 'role' => 'form','class'=>'color-555', 'id'=>'search-agency-city']) }}
                                                        <div class="row">
                                                            <div class="col-10 pr-0 mr-0">
                                                                <select class="custom-select custom-select-lg select2bs4 select2-hidden-accessible city-select2" id="search2-city"
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
                                                    <div class="col-md-4  col-sm-12 mb-2">
                                                        {{ Form::open(['route' => ['admin.agency.search.id'], 'method' => 'post', 'role' => 'form']) }}
                                                        <div class="row">
                                                            <div class="col-10 pr-0 mr-0">
                                                                <input class="form-control form-control-sm text-transform" type="text" placeholder="Agency ID" name="agency_id"
                                                                       autocomplete="false" required value="{{request()->query('id')}}">
                                                            </div>
                                                            <div class="col-2 px-0 mx-0">
                                                                <button class="btn btn-primary search-submit-btn btn-sm" type="Submit"><i class="fa fa-search ml-1"></i></button>
                                                            </div>
                                                        </div>
                                                        {{ Form::close() }}

                                                    </div>
                                                    <div class="col-md-4  col-sm-12">
                                                        {{ Form::open(['route' => ['admin.agency.search.name'], 'method' => 'post', 'role' => 'form']) }}
                                                        <div class="row">
                                                            <div class="col-10 pr-0 mr-0">
                                                                <input class="form-control form-control-sm text-transform" type="text" placeholder="Agency Name" name="agency_name"
                                                                       autocomplete="false" required value="{{request()->query('name')}}">
                                                            </div>
                                                            <div class="col-2 px-0 mx-0">
                                                                <button class="btn btn-primary search-submit-btn btn-sm" type="Submit"><i class="fa fa-search ml-1"></i></button>
                                                            </div>
                                                        </div>
                                                        {{ Form::close() }}

                                                    </div>
                                                    <div class="col-md-4 col-sm-12">
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
                                                <span><a class="btn btn-sm transition-background color-green mr-3 pull-right" href="{{route('admin-agencies-create')}}">Add New Agency</a></span>
                                                <div class="tab-pane fade {{\Illuminate\Support\Facades\Request::segments()[5] === 'all'? 'active show' : '' }}" id="listings-all" role="tabpanel"
                                                     aria-labelledby="listings-all-tab">
                                                    <h6 class="pull-left">All Listings</h6>
                                                    <div class="my-4">
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="theme-blue text-white">
                                                            <tr>
                                                                <td>ID</td>
                                                                <td>Title</td>
                                                                <td>Address</td>
                                                                <td>City</td>
                                                                <td>Website</td>
                                                                <td>Phone</td>
                                                                <td>Listed Date</td>
                                                                @if($params['status'] != 'verified_agencies')
                                                                    <td>Status Controls</td>
                                                                @endif
                                                                @if($params['status'] == 'verified_agencies')
                                                                    <td>Verified By</td>
                                                                @elseif($params['status'] == 'deleted_agencies')
                                                                    <td>Deleted By</td>
                                                                @elseif($params['status'] == 'rejected_agencies')
                                                                    <td>Rejected By</td>
                                                                @endif
                                                                <td colspan="2">Controls</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($listings['all'] as $all_listing)
                                                                <tr>
                                                                    <td>{{ $all_listing->id }}</td>
                                                                    <td>{{ $all_listing->title }}</td>
                                                                    <td>{{ $all_listing->address }}</td>
                                                                    <td class="pr-3">{{ $all_listing->city}}</td>
                                                                    <td>{{ $all_listing->website }}</td>
                                                                    <td>{{ str_replace('-','',$all_listing->cell) }}</td>
                                                                    {{--                                                                    <td>{{ (new \Illuminate\Support\Carbon($all_listing->listed_date))->format('Y-m-d') }}</td>--}}
                                                                    <td>{{ (new \Illuminate\Support\Carbon($all_listing->created_at))->isoFormat('DD-MM-YYYY  h:mm a') }}</td>
                                                                    @if($params['status'] == 'pending_agencies')
                                                                        <td>
                                                                            <div class="pending-status"><strong>Pending</strong></div>
                                                                        </td>
                                                                    @elseif($params['status'] == 'expired_agencies')
                                                                        <td>
                                                                            <div class="pending-status"><strong>Expired</strong></div>
                                                                        </td>
                                                                    @elseif($params['status'] == 'deleted_agencies')
                                                                        <td>
                                                                            <div class="rejected-status"><strong>Delete</strong></div>
                                                                        </td>
                                                                    @elseif($params['status'] == 'rejected_agencies')
                                                                        <td>
                                                                            <div class="rejected-status"><strong>Reject</strong></div>
                                                                        </td>

                                                                    @endif
                                                                    @if($params['status'] == 'verified_agencies')
                                                                        <td>{{ucwords($all_listing->reviewed_by)}}</td>
                                                                    @elseif($params['status'] == 'deleted_agencies')
                                                                        <td>{{ucwords($all_listing->reviewed_by)}}</td>
                                                                    @elseif($params['status'] == 'rejected_agencies')
                                                                        <td>{{ucwords($all_listing->reviewed_by)}}</td>
                                                                    @endif
                                                                    {{--                                                                    <td>--}}
                                                                    {{--                                                                        @if($params['status'] != 'deleted_agencies')--}}
                                                                    {{--                                                                            <a type="button" href="{{route('admin.agencies.add-users', $all_listing->id)}}" class="btn btn-sm btn-primary"--}}
                                                                    {{--                                                                               data-toggle-1="tooltip"--}}
                                                                    {{--                                                                               data-placement="bottom" title="Add user in agency">--}}
                                                                    {{--                                                                                <i class="fas fa-user-plus mr-2"></i>Add Agency Staff--}}
                                                                    {{--                                                                            </a>--}}
                                                                    {{--                                                                        @endif--}}

                                                                    {{--                                                                    </td>--}}
                                                                    <td>
                                                                        @if($params['status'] != 'deleted_agencies')

                                                                            @if($params['status'] == 'pending_agencies')
                                                                                <a type="button" href="{{route('admin-agencies-edit', $all_listing->id)}}"
                                                                                   class="btn btn-sm btn-warning mb-1"
                                                                                   data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="Edit Agency">
                                                                                    Review & Activate<span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                                </a>
                                                                            @elseif($params['status'] == 'verified_agencies')
                                                                                <a type="button" target="_blank"
                                                                                   href="{{route('agents.ads.listing',
                                                                                                [ 'city'=>strtolower(Str::slug($all_listing->city)),
                                                                                                   'slug'=>\Illuminate\Support\Str::slug($all_listing->title),
                                                                                                   'agency'=> $all_listing->id ,
                                                                                                   ])}}"
                                                                                   class="btn btn-sm btn-primary mb-1"
                                                                                   data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="View Agency Properties">
                                                                                    <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                                </a>
                                                                                <a type="button" href="{{route('admin-agencies-edit', $all_listing->id)}}"
                                                                                   class="btn btn-sm btn-warning mb-1"
                                                                                   data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="Edit Agency">
                                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                                </a>
                                                                                @if($all_listing->user_id == 1)
                                                                                    <a type="button" href="{{route('admin-agencies-owner-edit', $all_listing->id)}}"
                                                                                       class="btn btn-sm btn-success mb-1"
                                                                                       data-toggle-1="tooltip"
                                                                                       data-placement="bottom" title="Add Agency Owner">
                                                                                        <i class="fas fa-user"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Add Agency Owner</span>
                                                                                    </a>
                                                                                @endif

                                                                                @can('Delete Agencies')
                                                                                    <a type="button" class="btn btn-sm btn-danger mb-1"
                                                                                       data-toggle-1="tooltip"
                                                                                       data-placement="bottom" title="Delete Agency"
                                                                                       data-toggle="modal" data-target="#delete" data-record-id="{{$all_listing->id}}">
                                                                                        <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                                    </a>
                                                                                @endcan
                                                                            @elseif($params['status'] != 'pending_agencies' )

                                                                                <a type="button" href="{{route('admin-agencies-edit', $all_listing->id)}}"
                                                                                   class="btn btn-sm btn-warning mb-1"
                                                                                   data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="Edit Agency">
                                                                                    <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                                </a>
                                                                                @can('Delete Agencies')
                                                                                    <a type="button" class="btn btn-sm btn-danger mb-1"
                                                                                       data-toggle-1="tooltip"
                                                                                       data-placement="bottom" title="Delete Agency"
                                                                                       data-toggle="modal" data-target="#delete" data-record-id="{{$all_listing->id}}">
                                                                                        <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                                    </a>
                                                                                @endcan
                                                                            @endif
                                                                        @elseif($params['status'] == 'deleted_agencies')
                                                                            <a type="button" href="{{route('admin-agencies-edit', $all_listing->id)}}"
                                                                               class="btn btn-sm btn-success color-black restore-btn mb-1"
                                                                               data-toggle-1="tooltip"
                                                                               data-placement="bottom" title="Edit Agency">
                                                                                Review & Restore<span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                            </a>
                                                                            {{--                                                                    <a type="button" class="btn btn-sm btn-success color-black restore-btn"--}}
                                                                            {{--                                                                       data-toggle-1="tooltip" data-placement="bottom"--}}
                                                                            {{--                                                                       title="restore"--}}
                                                                            {{--                                                                       href="javascript:void(0)"--}}
                                                                            {{--                                                                       data-record-id="{{$all_listing->id}}">--}}
                                                                            {{--                                                                        Review & Restore<span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>--}}
                                                                            {{--                                                                    </a>--}}
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="p-4 text-center">No Listings Found!</td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>
                                                        {{--                                                        {{ $listings['all']->links() }}--}}
                                                        {{ $listings['all']->links('vendor.pagination.bootstrap-4') }}
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade {{\Illuminate\Support\Facades\Request::segments()[5] === 'key'? 'active show' : '' }}" id="listings-key" role="tabpanel"
                                                     aria-labelledby="listings-key-tab">
                                                    <h6>Key Agencies</h6>
                                                    <div class="my-4">
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="theme-blue text-white">
                                                            <tr>
                                                                <td>ID</td>
                                                                <td>Title</td>
                                                                <td>Address</td>
                                                                <td>City</td>
                                                                <td>Website</td>
                                                                <td>Phone</td>
                                                                <td>Listed Date</td>
                                                                @if($params['status'] != 'verified_agencies')
                                                                    <td>Status Controls</td>
                                                                @endif
                                                                @if($params['status'] == 'verified_agencies')
                                                                    <td>Verified By</td>
                                                                @elseif($params['status'] == 'deleted_agencies')
                                                                    <td>Deleted By</td>
                                                                @endif
                                                                <td colspan="2">Controls</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($listings['key'] as $key_listing)
                                                                <tr>
                                                                    <td>{{ $key_listing->id }}</td>
                                                                    <td>{{ $key_listing->title }}</td>
                                                                    <td>{{ $key_listing->address }}</td>
                                                                    <td class=" pr-3">{{ $key_listing->city }}</td>
                                                                    <td>{{ $key_listing->website }}</td>
                                                                    <td>{{ $key_listing->phone }}</td>
                                                                    {{--                                                                    <td>{{ (new \Illuminate\Support\Carbon($key_listing->listed_date))->format('Y-m-d') }}</td>--}}
                                                                    <td>{{ (new \Illuminate\Support\Carbon($key_listing->created_at))->isoFormat('DD-MM-YYYY  h:mm a') }}</td>
                                                                    @if($params['status'] == 'pending_agencies')
                                                                        <td>
                                                                            <div class="pending-status"><strong>Pending</strong></div>
                                                                        </td>
                                                                    @elseif($params['status'] == 'expired_agencies')
                                                                        <td>
                                                                            <div class="pending-status"><strong>Expired</strong></div>
                                                                        </td>
                                                                    @elseif($params['status'] == 'deleted_agencies')
                                                                        <td>
                                                                            <div class="rejected-status"><strong>deleted</strong></div>
                                                                        </td>
                                                                    @endif
                                                                    @if($params['status'] == 'verified_agencies')
                                                                        <td></td>
                                                                    @elseif($params['status'] == 'deleted_agencies')
                                                                        <td></td>
                                                                    @endif
                                                                    {{--                                                                    <td>--}}
                                                                    {{--                                                                        @if($params['status'] != 'deleted_agencies')--}}
                                                                    {{--                                                                            <a type="button" href="{{route('admin.agencies.add-users', $key_listing->id)}}" class="btn btn-sm btn-primary"--}}
                                                                    {{--                                                                               data-toggle-1="tooltip"--}}
                                                                    {{--                                                                               data-placement="bottom" title="Add user in agency">--}}
                                                                    {{--                                                                                <i class="fas fa-user-plus mr-2"></i>Add Agency Staff--}}
                                                                    {{--                                                                            </a>--}}
                                                                    {{--                                                                        @endif--}}

                                                                    {{--                                                                    </td>--}}
                                                                    <td>
                                                                        @if($params['status'] == 'verified_agencies')
                                                                            <a type="button" target="_blank"
                                                                               href="{{route('agents.ads.listing',
                                                                                                [ 'city'=>strtolower(Str::slug($key_listing->city)),
                                                                                                   'slug'=>\Illuminate\Support\Str::slug($key_listing->title),
                                                                                                   'agency'=> $key_listing->id ,
                                                                                                   ])}}"
                                                                               class="btn btn-sm btn-primary mb-1"
                                                                               data-toggle-1="tooltip"
                                                                               data-placement="bottom" title="View Agency Properties">
                                                                                <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                            </a>
                                                                            <a type="button" href="{{route('admin-agencies-edit', $key_listing->id)}}"
                                                                               class="btn btn-sm btn-warning mb-1"
                                                                               data-toggle-1="tooltip"
                                                                               data-placement="bottom" title="Edit Agency">
                                                                                <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                            </a>
                                                                            @if($all_listing->user_id == 1)
                                                                                <a type="button" href="{{route('admin-agencies-owner-edit', $all_listing->id)}}"
                                                                                   class="btn btn-sm btn-success mb-1"
                                                                                   data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="Add Agency Owner">
                                                                                    <i class="fas fa-user"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Add Agency Owner</span>
                                                                                </a>
                                                                            @endif
                                                                            @can('Delete Agencies')
                                                                                <a type="button" class="btn btn-sm btn-danger  {{$params['status'] == 'deleted' ?' anchor-disable':''}}"
                                                                                   data-toggle-1="tooltip" data-placement="bottom" title="Delete Agency"
                                                                                   data-toggle="modal" data-target="#delete"
                                                                                   data-record-id="{{$key_listing->id}}">
                                                                                    <i class="fas fa-trash color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                                </a>
                                                                            @endcan
                                                                        @elseif($params['status'] != 'deleted_agencies')
                                                                            <a type="button" href="{{route('admin-agencies-edit', $key_listing->id)}}"
                                                                               class="btn btn-sm btn-warning mb-1"
                                                                               data-toggle-1="tooltip"
                                                                               data-placement="bottom" title="Edit Agency">
                                                                                <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                            </a>
                                                                            @can('Delete Agencies')
                                                                                <a type="button" class="btn btn-sm btn-danger  {{$params['status'] == 'deleted' ?' anchor-disable':''}}"
                                                                                   data-toggle-1="tooltip" data-placement="bottom" title="Delete Agency"
                                                                                   data-toggle="modal" data-target="#delete"
                                                                                   data-record-id="{{$key_listing->id}}">
                                                                                    <i class="fas fa-trash color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                                </a>
                                                                            @endcan
                                                                        @elseif($params['status'] == 'deleted_agencies')
                                                                            <a type="button" class="btn btn-sm btn-success color-black restore-btn mb-1"
                                                                               data-toggle-1="tooltip" data-placement="bottom"
                                                                               title="Restore Agency"
                                                                               href="javascript:void(0)"
                                                                               data-record-id="{{$key_listing->id}}">
                                                                                <i class="fas fa-redo-alt color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="9" class="p-4 text-center">No Listings Found!</td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>

                                                        {{--                                                        {{ $listings['key']->links() }}--}}
                                                        {{ $listings['key']->links() }}
                                                    </div>
                                                </div>
                                                <div class="tab-pane fade {{\Illuminate\Support\Facades\Request::segments()[5] === 'featured'? 'active show' : '' }}" id="listings-featured"
                                                     role="tabpanel" aria-labelledby="listings-featured-tab">
                                                    <h6>Featured Agencies</h6>
                                                    <div class="my-4">
                                                        <table class="table table-sm table-bordered">
                                                            <thead class="theme-blue text-white">
                                                            <tr>
                                                                <td>ID</td>
                                                                <td>Title</td>
                                                                <td>Address</td>
                                                                <td>City</td>
                                                                <td>Website</td>
                                                                <td>Phone</td>
                                                                <td>Listed Date</td>
                                                                @if($params['status'] != 'verified_agencies')
                                                                    <td>Status Controls</td>
                                                                @endif
                                                                @if($params['status'] == 'verified_agencies')
                                                                    <td>Verified By</td>
                                                                @elseif($params['status'] == 'deleted_agencies')
                                                                    <td>Deleted By</td>
                                                                @endif
                                                                <td colspan="2">Controls</td>
                                                            </tr>
                                                            </thead>
                                                            <tbody>
                                                            @forelse($listings['featured'] as $featured_listing)
                                                                <tr>
                                                                    <td>{{ $featured_listing->id }}</td>
                                                                    <td>{{ $featured_listing->title }}</td>
                                                                    <td>{{ $featured_listing->address }}</td>
                                                                    <td class="pr-3">{{ $featured_listing->city }}</td>
                                                                    <td>{{ $featured_listing->website }}</td>
                                                                    <td>{{ $featured_listing->phone }}</td>
                                                                    {{--                                                                    <td>{{ (new \Illuminate\Support\Carbon($featured_listing->listed_date))->format('Y-m-d') }}</td>--}}
                                                                    <td>{{ (new \Illuminate\Support\Carbon($featured_listing->created_at))->isoFormat('DD-MM-YYYY  h:mm a') }}
                                                                    </td>
                                                                    @if($params['status'] == 'pending_agencies')
                                                                        <td>
                                                                            <div class="pending-status"><strong>Pending</strong></div>
                                                                        </td>
                                                                    @elseif($params['status'] == 'expired_agencies')
                                                                        <td>
                                                                            <div class="pending-status"><strong>Expired</strong></div>
                                                                        </td>
                                                                    @elseif($params['status'] == 'deleted_agencies')
                                                                        <td>
                                                                            <div class="rejected-status"><strong>deleted</strong></div>
                                                                        </td>
                                                                    @endif
                                                                    @if($params['status'] == 'verified_agencies')
                                                                        <td></td>
                                                                    @elseif($params['status'] == 'deleted_agencies')
                                                                        <td></td>
                                                                    @endif
                                                                    {{--                                                                    <td>--}}

                                                                    {{--                                                                        @if($params['status'] != 'deleted_agencies')--}}

                                                                    {{--                                                                            <a type="button" href="{{route('admin.agencies.add-users', $featured_listing->id)}}" class="btn btn-sm btn-primary"--}}
                                                                    {{--                                                                               data-toggle-1="tooltip"--}}
                                                                    {{--                                                                               data-placement="bottom" title="Add user in agency">--}}
                                                                    {{--                                                                                <i class="fas fa-user-plus mr-2"></i>Add Agency Staff--}}
                                                                    {{--                                                                            </a>--}}
                                                                    {{--                                                                        @endif--}}

                                                                    {{--                                                                    </td>--}}
                                                                    <td>
                                                                        @if($params['status'] == 'verified_agencies')
                                                                            <a type="button" target="_blank"
                                                                               href="{{route('agents.ads.listing',
                                                                                                [ 'city'=>strtolower(Str::slug($featured_listing->city)),
                                                                                                   'slug'=>\Illuminate\Support\Str::slug($featured_listing->title),
                                                                                                   'agency'=> $featured_listing->id ,
                                                                                                   ])}}"
                                                                               class="btn btn-sm btn-primary mb-1"
                                                                               data-toggle-1="tooltip"
                                                                               data-placement="bottom" title="View Agency Properties">
                                                                                <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                                                            </a>
                                                                            <a type="button" href="{{route('admin-agencies-edit', $featured_listing->id)}}"
                                                                               class="btn btn-sm btn-warning mb-1"
                                                                               data-toggle-1="tooltip"
                                                                               data-placement="bottom" title="Edit Agency">
                                                                                <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                            </a>
                                                                            @if($all_listing->user_id == 1)
                                                                                <a type="button" href="{{route('admin-agencies-owner-edit', $all_listing->id)}}"
                                                                                   class="btn btn-sm btn-success mb-1"
                                                                                   data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="Add Agency Owner">
                                                                                    <i class="fas fa-user"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Add Agency Owner </span>
                                                                                </a>
                                                                            @endif
                                                                            @can('Delete Agencies')
                                                                                <a type="button" class="btn btn-sm btn-danger mb-1" data-toggle-1="tooltip"
                                                                                   data-placement="bottom" title="Delete Agency"
                                                                                   data-toggle="modal" data-target="#delete"
                                                                                   data-record-id="{{$featured_listing->id}}">
                                                                                    <i class="fas fa-trash color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                                </a>
                                                                            @endcan
                                                                        @elseif($params['status'] != 'deleted_agencies')

                                                                            <a type="button" href="{{route('admin-agencies-edit', $featured_listing->id)}}"
                                                                               class="btn btn-sm btn-warning mb-1"
                                                                               data-toggle-1="tooltip"
                                                                               data-placement="bottom" title="Edit Agency">
                                                                                <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                                                            </a>
                                                                            <a type="button" class="btn btn-sm btn-danger mb-1" data-toggle-1="tooltip" data-placement="bottom" title="Delete Agency"
                                                                               data-toggle="modal" data-target="#delete"
                                                                               data-record-id="{{$featured_listing->id}}">
                                                                                <i class="fas fa-trash color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                                                            </a>
                                                                        @elseif($params['status'] == 'deleted_agencies')
                                                                            <a type="button"
                                                                               class="btn btn-sm btn-success color-black restore-btn mb-1{{$params['status'] == 'deleted' ?'':'anchor-disable'}}"
                                                                               data-toggle-1="tooltip" data-placement="bottom"
                                                                               title="Restore Agency"
                                                                               href="javascript:void(0)"
                                                                               data-record-id="{{$featured_listing->id}}">
                                                                                <i class="fas fa-redo-alt color-white"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                                                            </a>
                                                                        @endif
                                                                    </td>
                                                                </tr>
                                                            @empty
                                                                <tr>
                                                                    <td colspan="8" class="p-4 text-center">No Listings Found!</td>
                                                                </tr>
                                                            @endforelse
                                                            </tbody>
                                                        </table>

                                                        {{--                                                        {{ $listings['featured']->links() }}--}}
                                                        {{ $listings['featured']->links('vendor.pagination.bootstrap-4') }}
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
        </div>
    </div>
    @include('website.admin-pages.layouts.delete-modal', array('route'=>'agencies'))
@endsection

@section('script')
    <script src="{{asset('plugins/select2/js/select2.full.min.js')}}"></script>
    <script src="{{asset('website/js/bootstrap.min.js')}}"></script>
    <script src="{{asset('website/js/admin-agency-listings.js')}}" defer></script>
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
