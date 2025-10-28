@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection

@push('css-page')
<style>
    .apexcharts-yaxis
    {
        transform: translate(20px, 0px) !important;
    }
</style>
@endpush

@push('script-page')
    <script>
        (function() {
            var options = {
                chart: {
                    height: 350,
                    type: 'area',
                    toolbar: {
                        show: false,
                    },
                },
                dataLabels: {
                    enabled: false
                },
                stroke: {
                    width: 2,
                    curve: 'smooth'
                },
                series: [{
                    name: '{{ __('Purchase') }}',
                    data: {!! json_encode($purchasesArray['value']) !!}
                    // data:  [70,270,80,245,115,260,135,280,70,215]

                },
                    {
                        name: '{{ __('POS') }}',
                        data: {!! json_encode($posesArray['value']) !!}

                        // data:  [100,300,100,260,140,290,150,300,100,250]

                    },
                ],
                xaxis: {
                    categories: {!! json_encode($purchasesArray['label']) !!},
                    title: {
                        text: '{{ __('Days') }}'
                    }
                },
                colors: ['#ff3a6e', '#6fd943'],

                grid: {
                    strokeDashArray: 4,
                },
                legend: {
                    show: false,
                },
                // markers: {
                //     size: 4,
                //     colors: ['#ffa21d', '#FF3A6E'],
                //     opacity: 0.9,
                //     strokeWidth: 2,
                //     hover: {
                //         size: 7,
                //     }
                // },
                yaxis: {
                    title: {
                        text: '{{ __('Amount') }}',
                        offsetX: 30,
                        offsetY: -35,
                    },
                }
            };
            var chart = new ApexCharts(document.querySelector("#traffic-chart"), options);
            chart.render();
        })();

    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('POS')}}</li>
@endsection
@section('content')
    <div class="row gy-4">
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 pos-dash-card">
            <div class="pos-card-inner card mb-0 d-flex flex-column justify-content-between pps-paddi">
              
                <div class="pos-info-wrp d-flex align-items-center gap-2  justify-content-between">
                    <div>
                        <img  src="{{ asset('assets/images/design-images/All/Pos-1.svg') }}"  alt="">
                        <a href="{{ route('pos.report') }}" class="dashboard-link">{{ __('POS Of This Month') }}</a>
                    </div>
                    <div class="pos-price d-flex gap-2 align-items-end flex-column text-center bg-1-dif">
                        <span>{{ __('total') }}</span>
                        <h3 class="mb-0">{{$pos_data['monthlyPosAmount']}}</h3>
                    </div>
                </div>
               
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 pos-dash-card">
            <div class="pos-card-inner card mb-0 d-flex flex-column justify-content-between pps-paddi">
               
                <div class="pos-info-wrp d-flex align-items-center gap-2  justify-content-between">
                    <div>
                        <img  src="{{ asset('assets/images/design-images/All/Pos-2.svg') }}"  alt="">
                        <a href="{{ route('pos.report') }}" class="dashboard-link">{{ __('POS Amount') }}</a>
                    </div>
                    <div class="pos-price d-flex gap-2 align-items-end flex-column text-center bg-2-dif">
                        <span>{{ __('total') }}</span>
                        <h3 class="mb-0">{{$pos_data['totalPosAmount']}}</h3>
                    </div>
                </div>
                
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 pos-dash-card">
            <div class="pos-card-inner card mb-0 d-flex flex-column justify-content-between pps-paddi">
                <div class="pos-info-wrp d-flex align-items-center gap-2  justify-content-between">
                    <div>
                        <img  src="{{ asset('assets/images/design-images/All/Pos-3.svg') }}"  alt="">
                        <a href="{{ route('purchase.index') }}" class="dashboard-link">{{ __('Purchase Of This Month') }}</a>
                    </div>
                    <div class="pos-price d-flex gap-2 flex-column align-items-end text-center bg-3-dif">
                        <span>{{ __('total') }}</span>
                        <h3 class="mb-0">{{$pos_data['monthlyPurchaseAmount']}}</h3>
                    </div>
                </div>
              
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 pos-dash-card">
            <div class="pos-card-inner card mb-0 d-flex flex-column justify-content-between pps-paddi">
                <div class="pos-info-wrp d-flex align-items-center gap-2  justify-content-between">
                    <div>
                        <img  src="{{ asset('assets/images/design-images/All/Pos-4.svg') }}"  alt="">
                        <a href="{{ route('purchase.index') }}" class="dashboard-link">{{ __(' Purchase Amount') }}</a>
                    </div>
                    <div class="pos-price d-flex gap-2 align-items-end flex-column text-center bg-4-dif">
                        <span>{{ __('total') }}</span>
                        <h3 class="mb-0">{{$pos_data['totalPurchaseAmount']}}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <div class="row ">
                        <div class="col-6">
                            <h5>{{ __('Purchase Vs POS Report') }}</h5>
                        </div>
                        <div class="col-6 text-end">
                            <h6>{{ __('Last 10 Days') }}</h6>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div id="traffic-chart"></div>
                </div>
            </div>
        </div>

    </div>
@endsection
