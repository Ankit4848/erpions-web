@extends('layouts.admin')
@section('page-title')
    {{__('Manage Job')}}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('Job')}}</li>
@endsection
@push('script-page')


    <script>
        function copyToClipboard(element) {

            var copyText = element.id;
            navigator.clipboard.writeText(copyText);
            // document.addEventListener('copy', function (e) {
            //     e.clipboardData.setData('text/plain', copyText);
            //     e.preventDefault();
            // }, true);
            //
            // document.execCommand('copy');
            show_toastr('success', 'Url copied to clipboard', 'success');
        }
    </script>


@endpush


@section('action-btn')
    <div class="float-end">
        @can('create job')
            <a href="{{ route('job.create') }}" class="btn btn-sm btn-primary"  data-bs-toggle="tooltip" title="{{__('Create')}}" data-title="{{__('Create New Job')}}">
                <i class="ti ti-plus"></i>
            </a>
        @endcan
    </div>
@endsection

@section('content')
<div class="row mb-4 gy-4">
    <div class="col-xl-4 col-sm-6 col-12 job-info-card">
        <div class="job-card-inner d-flex align-items-center gap-3">
           
            <img src="{{ asset('assets/images/design-images/All/Pos-1.svg') }}" alt="">
           
            <div class="job-content d-flex align-items-center justify-content-between flex-1">
                <div class="job-content-inner">
                    <span class="text-sm d-block mb-1">{{ __('Total') }}</span>
                    <h2 class="h5 mb-0">{{ __('Jobs') }}</h2>
                </div>
                <h3 class="h4 mb-0">{{ $data['total'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 col-12 job-info-card">
        <div class="job-card-inner d-flex align-items-center gap-3">
          
        
            <img src="{{ asset('assets/images/design-images/All/Pos-2.svg') }}" alt="">
        

            <div class="job-content d-flex align-items-center justify-content-between flex-1">
                <div class="job-content-inner">
                    <span class="text-sm d-block mb-1">{{ __('Active') }}</span>
                    <h2 class="h5 mb-0">{{ __('Jobs') }}</h2>
                </div>
                <h3 class="h4 mb-0">{{ $data['active'] }}</h3>
            </div>
        </div>
    </div>
    <div class="col-xl-4 col-sm-6 col-12 job-info-card">
        <div class="job-card-inner d-flex align-items-center gap-3">
        
            <img src="{{ asset('assets/images/design-images/All/Pos-3.svg') }}" alt="">


            <div class="job-content d-flex align-items-center justify-content-between flex-1">
                <div class="job-content-inner">
                    <span class="text-sm d-block mb-1">{{ __('Inactive') }}</span>
                    <h2 class="h5 mb-0">{{ __('Jobs') }}</h2>
                </div>
                <h3 class="h4 mb-0">{{ $data['in_active'] }}</h3>
            </div>
        </div>
    </div>
</div>


    <div class="row">
        <div class="col-md-12">
            <div class="card">
            <div class="card-body table-border-style">
                    <div class="table-responsive">
                    <table class="table datatable">
                            <thead>
                            <tr>
                                <th>{{__('Branch')}}</th>
                                <th>{{__('Title')}}</th>
                                <th>{{__('Start Date')}}</th>
                                <th>{{__('End Date')}}</th>
                                <th>{{__('Status')}}</th>
                                <th>{{__('Created At')}}</th>
                                @if( Gate::check('edit job') ||Gate::check('delete job') ||Gate::check('show job'))
                                    <th width="200px">{{__('Action')}}</th>
                                @endif
                            </tr>
                            </thead>
                            <tbody class="font-style">
                            @foreach ($jobs as $job)
                                <tr>
                                    <td>{{ !empty($job->branches)?$job->branches->name:__('All') }}</td>
                                    <td>{{$job->title}}</td>
                                    <td>{{\Auth::user()->dateFormat($job->start_date)}}</td>
                                    <td>{{\Auth::user()->dateFormat($job->end_date)}}</td>
                                    <td>
                                        @if($job->status=='active')
                                            <span class="status_badge badge bg-primary p-2 px-3 rounded">{{App\Models\Job::$status[$job->status]}}</span>
                                        @else
                                            <span class="status_badge badge bg-danger p-2 px-3 rounded">{{App\Models\Job::$status[$job->status]}}</span>
                                        @endif
                                    </td>
                                    <td>{{ \Auth::user()->dateFormat($job->created_at) }}</td>
                                    @if( Gate::check('edit job') ||Gate::check('delete job') || Gate::check('show job'))
                                        <td>

                                        @if($job->status!='in_active')

                                                <div class="action-btn me-2">
                                                    <a href="#" id="{{ route('job.requirement',[$job->code,!empty($job)?$job->createdBy->lang:'en']) }}" class="mx-3 btn btn-sm align-items-center bg-secondary"  onclick="copyToClipboard(this)" data-bs-toggle="tooltip" title="{{__('Copy')}}" data-original-title="{{__('Click to copy')}}"><i class="ti ti-link text-white"></i></a>
                                                </div>


                                            @endif
                                            @can('show job')
                                            <div class="action-btn me-2">
                                                <a href="{{ route('job.show',$job->id) }}" data-title="{{__('Job Detail')}}" title="{{__('View')}}"  class="mx-3 btn btn-sm align-items-center bg-warning" data-bs-toggle="tooltip" data-original-title="{{__('View Detail')}}">
                                                    <i class="ti ti-eye text-white"></i></a>
                                            </div>
                                                @endcan
                                            @can('edit job')
                                            <div class="action-btn me-2">
                                                <a href="{{ route('job.edit',$job->id) }}" data-title="{{__('Edit Job')}}" class="mx-3 btn btn-sm align-items-center bg-info" data-bs-toggle="tooltip" title="{{__('Edit')}}" data-original-title="{{__('Edit')}}">
                                                    <i class="ti ti-pencil text-white"></i></a>
                                            </div>
                                                @endcan
                                            @can('delete job')
                                            <div class="action-btn ">
                                            {!! Form::open(['method' => 'DELETE', 'route' => ['job.destroy', $job->id],'id'=>'delete-form-'.$job->id]) !!}

                                                <a href="#" class="mx-3 btn btn-sm align-items-center bs-pass-para bg-danger" data-bs-toggle="tooltip" title="{{__('Delete')}}" data-original-title="{{__('Delete')}}" data-confirm="{{__('Are You Sure?').'|'.__('This action can not be undone. Do you want to continue?')}}" data-confirm-yes="document.getElementById('delete-form-{{$job->id}}').submit();">
                                                    <i class="ti ti-trash text-white"></i></a>
                                                {!! Form::close() !!}
                                                </div>
                                            @endcan
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
