<span class="tab-content" id="listings-tabContent">
    @foreach(['all'] as $option)
        <div class="tab-pane fade show active" id="{{"listings-".$option}}"
             role="tabpanel" aria-labelledby="{{"listings-".$option."-tab"}}">
             <h6 class="pull-left">Agent Listings</h6>
            <span class="pull-right mx-1">
                {{ Form::open(['route' => ['property.user.search.id'], 'method' => 'post', 'role' => 'form','class'=>' color-555', 'style' => 'max-width:300px;']) }}
                    <div class="input-group input-group-sm mb-3">
                        <input class="form-control form-control-sm text-transform" type="number" placeholder="Property ID" name="property_id" autocomplete="false" required>
                    <div class="input-group-append"><span class="fa-stack"><i class="fa fa-search fa-stack-1x"></i></span></div></div>
                {{ Form::close() }}
            </span>
            <span class="pull-right mx-1">
            <select class="sorting form-control form-control-sm" style="width: 100%">
                <option value selected disabled data-index="0">Select Sorting Option</option>
                <option value="oldest" {{ $params['order'] === 'asc' || request()->query('sort') === 'oldest'  ? 'selected' : '' }}>Oldest
                </option>
                <option value="newest" {{ $params['order'] === 'desc' || request()->query('sort') === 'newest'  ? 'selected' : '' }}>Newest
                </option>
            </select>
            </span>
            <span class="pull-right mx-1">
              <select class="form-control form-control-sm agency_users" style="width: 100%" data-placeholder="Select Agency Member">
                                                        <option value disabled data-index="-1">Select Contact Person</option>
                                                        <option value="all" selected>All</option>
                                                        @foreach (Auth::user()->agencies->where('status','verified') as $agency)
                      <option class="font-weight-bold agency-name" data-agency="{{$agency->id}}" value="{{$agency->id}}">{{$agency->title}}</option>
                      @foreach ($agency->agencyUsers as $agency_user)
                          @if($agency_user->user->id !== Auth::user()->id)
                              <option value="{{$agency_user->user->id}}" data-agency="{{$agency->id}}" data-user="{{$agency_user->user->id}}">{{$agency_user->user->name}}</option>
                          @endif
                      @endforeach
                  @endforeach
                                                    </select>
            </span>
            <div class="my-4 component-block">
                <div class="table-responsive">
                    <table class="table table-sm table-bordered">
                        <thead class="theme-blue text-white">
                        <tr>
                            <td>ID</td>
                            {{-- <td>Reference</td>--}}
                            <td>Type</td>
                            <td>Location</td>
                            <td>Price (PKR)</td>
                            <td>Added By</td>
{{--                            <td>Contact Person</td>--}}
                            {{--                            <td>Contact #</td>--}}
                            <td>Listed For</td>
                            <td>Listed Date</td>
                            @if($params['status'] == 'active')
                                <td>Activation Date</td>
                                  <td>Package</td>
                            @endif
                            @if($params['status'] != 'deleted' || $params['status'] != 'pending' )
                                <td>Status Controls</td>
                            @endif
                            <td>Controls</td>
                        </tr>
                        </thead>
                        <tbody>
                        @if($listings[$option] !== null)
                            @forelse($listings[$option] as $all_listing)
                                <tr>
                                    <td>{{ $all_listing->id }}</td>
                                    {{-- <td>{{ $all_listing->reference}}</td>--}}
                                    <td>{{ $all_listing->type }}</td>
                                    <td>{{ $all_listing->location }}, {{$all_listing->city}}</td>
                                    @if($all_listing->price != '0')
                                        <td class="text-right pr-3">{{  $all_listing->price}}</td>
                                    @else
                                        <td class="pr-3">{{ 'Call option selected for price'}}</td>
                                    @endif
                                    <td>{{\App\Models\Dashboard\User::getUserName($all_listing->user_id)}}</td>
                                    <td>{{$all_listing->agency_id == null ? 'Individual':'Agency ('.\App\Models\Agency::getAgencyTitle($all_listing->agency_id) .')'}}</td>
                                    <td>{{ (new \Illuminate\Support\Carbon($all_listing->created_at))->isoFormat('DD-MM-YYYY  h:mm a') }}</td>

                                     @if($params['status'] == 'active')
                                        <td>
                                        <div> {{ (new \Illuminate\Support\Carbon($all_listing->activated_at))->isoFormat('DD-MM-YYYY  h:mm a') }}
                                        </div>
                                                                                <div class="badge badge-success p-2">
                                                                                    @if(str_contains ( (new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1]), 'ago' ))
                                                                                        <strong
                                                                                            class="color-white font-12"> Expired {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1])}}</strong>
                                                                                    @else
                                                                                        <strong
                                                                                            class="color-white font-12"> Expires in {{(new \Illuminate\Support\Carbon($all_listing->expired_at))->diffForHumans(['parts' => 1])}}</strong>
                                                                                    @endif
                                                                               </div>
                                                                            </td>
                                        <td>
                                                                                @if($all_listing->golden_listing == 1)
                                                Gold
                                            @elseif($all_listing->silver_listing == 1)
                                                Silver
                                            @else
                                                Basic
                                            @endif
                                                                            </td>
                                    @endif

                                    @if($params['status'] != 'deleted')
                                        <td>
                                            @if($params['status'] === 'sold')
                                                <div class="sold-status"><strong>Property Sold</strong>
                                                </div>
                                            @else
                                                <form>
                                                    @if($params['status'] != 'expired')

                                                    @endif
                                                    @if($params['status'] != 'active' && $params['status'] != 'pending')
                                                        <input type="radio" name="status" value="reactive" class="mb-1"
                                                               {{$all_listing->status === 'active'? 'disabled':'' }}
                                                               data-id="{{ $all_listing->id }}">
                                                        <label for="active">Active</label>
                                                    @endif
                                                    @if($params['status'] != 'expired')
                                                        <input type="radio" name="status" value="expired" class="mb-1"
                                                               {{$all_listing->status === 'expired'? 'checked':'' }}
                                                               {{$all_listing->status === 'sold'? 'checked':'' }}
                                                               data-id="{{ $all_listing->id }}" {{$all_listing->status === 'expired'? 'checked':'' }}>
                                                        <label for="expired">Expired</label>
                                                    @endif
                                                    @if($params['status'] != 'sold')
                                                        <input type="radio" name="status" value="sold" class="mb-1"
                                                               data-id="{{ $all_listing->id }}" {{$all_listing->status === 'sold'? 'checked':'' }}>
                                                        <label for="sold">Sold</label>
                                                    @endif
                                                </form>
                                            @endif
                                        </td>
                                    @else
                                        <td></td>
                                    @endif
                                    <td>
                                        @if($params['status'] == 'active')
                                            <a type="button" target="_blank" href="{{$all_listing->property_detail_path()}}"
                                               class="btn btn-sm btn-primary mb-1"
                                               data-toggle-1="tooltip"
                                               data-placement="bottom" title="view">
                                                <i class="fas fa-eye"></i><span class="sr-only sr-only-focusable" aria-hidden="true">View</span>
                                            </a>
                                        @endif
                                        @if($params['status'] != 'sold' && $params['status'] != 'deleted')
                                            <a type="button"
                                               href="{{$params['status'] == 'deleted' || $params['status'] == 'sold' ?
                                                    '': route('properties.edit', $all_listing->id)}}"
                                               class="btn btn-sm btn-warning mb-1
                                                {{$params['status'] == 'deleted' ? 'anchor-disable':'' }}
                                               {{$params['status'] == 'sold' ? 'anchor-disable':'' }}"
                                               data-toggle-1="tooltip"
                                               data-placement="bottom" title="edit">
                                                <i class="fas fa-pencil"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Edit</span>
                                            </a>
                                            <a type="button" class="btn btn-sm btn-danger mb-1" data-toggle-1="tooltip"
                                               data-placement="bottom" title="delete"
                                               data-toggle="modal" data-target="#delete"
                                               data-record-id="{{$all_listing->id}}">
                                                <i class="fas fa-trash"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Delete</span>
                                            </a>
                                        @elseif($params['status'] == 'deleted')
                                            <a type="button"
                                               class="btn btn-sm btn-success color-black restore-btn mb-1
                                                {{$params['status'] == 'deleted' ?'':'anchor-disable'}}"
                                               data-toggle-1="tooltip" data-placement="bottom"
                                               title="restore"
                                               href="javascript:void(0)"
                                               data-record-id="{{$all_listing->id}}">
                                                <i class="fas fa-redo-alt"></i><span class="sr-only sr-only-focusable" aria-hidden="true">Restore</span>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="12" class="p-4 text-center">No Listings Found!</td>
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
                {{--                @if($listings[$option] !== null)--}}
                {{--                    {{ $listings[$option]->links('vendor.pagination.bootstrap-4') }}--}}
                {{--                @endif--}}
            </div>
        </div>
    @endforeach
</span>
