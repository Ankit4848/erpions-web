@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
    <script>

    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('CRM')}}</li>
@endsection
@section('content')
<div class="row mb-4 gy-3">
    <div class="col-xl-4 col-sm-6 col-12 crm-dash-card">
        <div class="crm-card-inner d-flex align-items-center gap-3">
            <img  src="{{ asset('assets/images/design-images/All/Crm-Tl.svg') }}"  alt="">
            <div class="crm-content d-flex align-items-center gap-2 flex-wrap justify-content-between">
                <h2 class="h4 m-0">
                    <a href="{{ route('leads.index') }}" class="dashboard-link">{{ __('Total Lead') }}</a>
                </h2>
                <h3 class="h4 mb-2">{{ $crm_data['total_leads'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 col-12 crm-dash-card">
        <div class="crm-card-inner d-flex align-items-center gap-3">
            <img  src="{{ asset('assets/images/design-images/All/Crm-Td.svg') }}"  alt="">
            
            <div class="crm-content d-flex align-items-center gap-2 flex-wrap justify-content-between">
                <h2 class="h4 m-0">
                    <a href="{{ route('deals.index') }}" class="dashboard-link">{{ __('Total Deal') }}</a>
                </h2>
                <h3 class="h4 mb-2">{{ $crm_data['total_deals'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 col-12 crm-dash-card">
        <div class="crm-card-inner d-flex align-items-center gap-3">
            <img  src="{{ asset('assets/images/design-images/All/Crm-Tc.svg') }}"  alt="">
           
            <div class="crm-content d-flex align-items-center gap-2 flex-wrap justify-content-between">
                <h2 class="h4 m-0">
                    <a href="{{ route('contract.index') }}" class="dashboard-link">{{ __('Total Contract') }}</a>
                </h2>
                <h3 class="h4 mb-2">{{ $crm_data['total_contracts'] }}</h3>
            </div>
        </div>
    </div>
</div>
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card h-100 mb-0">
                <div class="card-header">
                    <h5>{{__('Lead Status')}}</h5>
                </div>
                <div class="card-body">
                    <div class="row ">
                        @foreach($crm_data['lead_status'] as $status => $val)
                            <div class="col-md-6 col-sm-6 mb-4">
                                <div class="align-items-start">
                                    <div class="ms-2">
                                        <p class="text-sm mb-2">{{$val['lead_stage']}}</p>
                                        <h3 class="mb-2 text-primary">{{ $val['lead_percentage'] }}%</h3>
                                        <div class="progress mb-0">
                                            <div class="progress-bar bg-primary" style="width:{{$val['lead_percentage']}}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mb-4">
            <div class="card h-100 mb-0">
                <div class="card-header">
                    <h5>{{__('Deal Status')}}</h5>
                </div>
                <div class="card-body">
                    <div class="row ">
                        @foreach($crm_data['deal_status'] as $status => $val)
                            <div class="col-md-6 col-sm-6 mb-4">
                                <div class="align-items-start">
                                    <div class="ms-2">
                                        <p class="text-sm mb-2">{{$val['deal_stage']}}</p>
                                        <h3 class="mb-2 text-primary">{{ $val['deal_percentage'] }}%</h3>
                                        <div class="progress mb-0">
                                            <div class="progress-bar bg-primary" style="width:{{$val['deal_percentage']}}%;"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xxl-12">
            <div class="card">
                <div class="card-header" style="border-bottom: none;">
                    <h5 class="mt-1 mb-0">{{__('Latest Contract')}}</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                            <tr>
                                <th></th>
                                <th>{{__('Subject')}}</th>
                                @if(\Auth::user()->type!='client')
                                <th>{{__('Client')}}</th>
                                @endif
                                <th>{{__('Project')}}</th>
                                <th>{{__('Contract Type')}}</th>
                                <th>{{__('Contract Value')}}</th>
                                <th>{{__('Start Date')}}</th>
                                <th>{{__('End Date')}}</th>
                            </tr>
                            </thead>
                            <tbody>
                            @forelse($crm_data['latestContract'] as $contract)
                                <tr>
                                    <td>
                                        <a href="{{route('contract.show',$contract->id)}}" class="btn btn-outline-primary">{{\Auth::user()->contractNumberFormat($contract->id)}}</a>
                                    </td>
                                    <td>{{ $contract->subject}}</td>
                                    @if(\Auth::user()->type!='client')
                                        <td>{{ !empty($contract->clients)?$contract->clients->name:'-' }}</td>
                                    @endif
                                    <td>{{ !empty($contract->projects)?$contract->projects->project_name:'-' }}</td>
                                    <td>{{ !empty($contract->types)?$contract->types->name:'' }}</td>
                                    <td>{{ \Auth::user()->priceFormat($contract->value) }}</td>
                                    <td>{{ \Auth::user()->dateFormat($contract->start_date )}}</td>
                                    <td>{{ \Auth::user()->dateFormat($contract->end_date )}}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8">
                                        <div class="text-center">
                                            <h6>{{__('There is no latest contract')}}</h6>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
