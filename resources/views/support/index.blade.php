@extends('layouts.admin')
@push('script-page')
@endpush
@section('page-title')
    {{ __('Support') }}
@endsection
@section('title')
    <div class="d-inline-block">
        <h5 class="h4 d-inline-block font-weight-400 mb-0 ">{{ __('Support') }}</h5>
    </div>
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item">{{ __('Support') }}</li>
@endsection

@section('action-btn')
    <div class="float-end">
        <a href="{{ route('support.grid') }}" class="me-1" 
            title="{{ __('Grid View') }}">
            <img src="{{ asset('assets/images/design-images/All/grid-view.svg') }}" alt="" style="width: 37px;">
        </a>
        <a href="#" data-size="lg" data-url="{{ route('support.create') }}" data-ajax-popup="true"
             title="{{ __('Create') }}" data-title="{{ __('Create Support') }}">
             <img src="{{ asset('assets/images/design-images/All/table-3.svg') }}" alt="" style="width: 37px;">
        </a>
    </div>
@endsection

@section('content')
    <div class="row mb-4 gy-4">
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 support-ticket-card">
            <div class="support-card-inner d-flex align-items-start gap-3">
              
               <img src="{{ asset('assets/images/design-images/All/ticket-1.svg') }}" alt="">
                <div class="support-content flex-1">
                    <span class="dashboard-link d-block mb-1" style="font-weight: 500 !important;">{{ __('Total') }}</span>
                    <h4 class="h5 mb-0">{{ __('Ticket') }}</h4>
                </div>
                <h3 class="mb-0 h4">{{ $countTicket }}</h3>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 support-ticket-card">
            <div class="support-card-inner d-flex align-items-start gap-3">
                <img src="{{ asset('assets/images/design-images/All/ticket-2.svg') }}" alt="">
                <div class="support-content flex-1">
                    <span class="dashboard-link d-block mb-1" style="font-weight: 500 !important;">{{ __('Open') }}</span>
                    <h4 class="h5 mb-0">{{ __('Ticket') }}</h4>
                </div>
                <h3 class="mb-0 h4">{{ $countOpenTicket }}</h3>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 support-ticket-card">
            <div class="support-card-inner d-flex align-items-start gap-3">
                <img src="{{ asset('assets/images/design-images/All/ticket-3.svg') }}" alt="">
                <div class="support-content flex-1">
                    <span class="dashboard-link d-block mb-1" style="font-weight: 500 !important;">{{ __('On Hold') }}</span>
                    <h4 class="h5 mb-0">{{ __('Ticket') }}</h4>
                </div>
                <h3 class="mb-0 h4">{{ $countonholdTicket }}</h3>
            </div>
        </div>
        <div class="col-xxl-3 col-xl-4 col-sm-6 col-12 support-ticket-card">
            <div class="support-card-inner d-flex align-items-start gap-3">
                <img src="{{ asset('assets/images/design-images/All/ticket-4.svg') }}" alt="">
                <div class="support-content flex-1">
                    <span class="dashboard-link d-block mb-1" style="font-weight: 500 !important;">{{ __('Close') }}</span>
                    <h4 class="h5 mb-0">{{ __('Ticket') }}</h4>
                </div>
                <h3 class="mb-0 h4">{{ $countCloseTicket }}</h3>
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
                                    <th scope="col">{{ __('Created By') }}</th>
                                    <th scope="col">{{ __('Ticket') }}</th>
                                    <th scope="col">{{ __('Code') }}</th>
                                    <th scope="col">{{ __('Attachment') }}</th>
                                    <th scope="col">{{ __('Assign User') }}</th>
                                    <th scope="col">{{ __('Status') }}</th>
                                    <th scope="col">{{ __('Created At') }}</th>
                                    <th scope="col">{{ __('Action') }}</th>
                                </tr>
                            </thead>
                            <tbody class="list">
                                @php
                                    $supportpath = \App\Models\Utility::get_file('uploads/supports');
                                @endphp
                                @foreach ($supports as $support)
                                    <tr>
                                        <td scope="row">
                                            <div class="media align-items-center">
                                                <div>
                                                    <div class="avatar-parent-child">
                                                        <img alt=""
                                                            class="avatar rounded border-2 border border-primary avatar-sm me-1"
                                                            @if (
                                                                !empty($support->createdBy) &&
                                                                    !empty($support->createdBy->avatar) &&
                                                                    file_exists('storage/uploads/avatar/' . $support->createdBy->avatar)) src="{{ asset(Storage::url('uploads/avatar')) . '/' . $support->createdBy->avatar }}" @else  src="{{ asset(Storage::url('uploads/avatar')) . '/avatar.png' }}" @endif>
                                                        @if ($support->replyUnread() > 0)
                                                            <span class="avatar-child avatar-badge bg-success"></span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="media-body">
                                                    {{ !empty($support->createdBy) ? $support->createdBy->name : '' }}
                                                </div>
                                            </div>
                                        </td>
                                        <td scope="row">
                                            <div class="media align-items-center">
                                                <div class="media-body">
                                                    <a href="{{ route('support.reply', \Crypt::encrypt($support->id)) }}"
                                                        class="name h6 mb-2 d-block text-sm">{{ $support->subject }}</a>
                                                    @if ($support->priority == 0)
                                                        <span data-toggle="tooltip" data-title="{{ __('Priority') }}"
                                                            class="text-capitalize status_badge badge bg-primary p-2 px-3 rounded">
                                                            {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                                    @elseif($support->priority == 1)
                                                        <span data-toggle="tooltip" data-title="{{ __('Priority') }}"
                                                            class="text-capitalize status_badge badge bg-info p-2 px-3 rounded">
                                                            {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                                    @elseif($support->priority == 2)
                                                        <span data-toggle="tooltip" data-title="{{ __('Priority') }}"
                                                            class="text-capitalize status_badge badge bg-warning p-2 px-3 rounded">
                                                            {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                                    @elseif($support->priority == 3)
                                                        <span data-toggle="tooltip" data-title="{{ __('Priority') }}"
                                                            class="text-capitalize status_badge badge bg-danger p-2 px-3 rounded">
                                                            {{ __(\App\Models\Support::$priority[$support->priority]) }}</span>
                                                    @endif
                                                </div>
                                            </div>
                                        </td>
                                        <td>{{ $support->ticket_code }}</td>
                                        <td>
                                            @if (!empty($support->attachment))
                                                <a class="bg-primary ms-2 btn btn-sm align-items-center"
                                                    href="{{ $supportpath . '/' . $support->attachment }}" download=""
                                                    data-bs-toggle="tooltip" title="{{ __('Download') }}"
                                                    target="_blank">
                                                    <i class="ti ti-download text-white"></i>
                                                </a>
                                                <a href="{{ $supportpath . '/' . $support->attachment }}"
                                                    class=" bg-secondary ms-2 mx-3 btn btn-sm align-items-center"
                                                    data-bs-toggle="tooltip" title="{{ __('Preview') }}">
                                                    <span class="btn-inner--icon"><i
                                                            class="ti ti-crosshair text-white"></i></span>
                                                </a>
                                            @else
                                                -
                                            @endif

                                        </td>
                                        <td>{{ !empty($support->assignUser) ? $support->assignUser->name : '-' }}</td>

                                        <td>
                                            @if ($support->status == 'Open')
                                                <span
                                                    class="status_badge text-capitalize badge bg-success p-2 px-3 rounded">{{ __(\App\Models\Support::$status[$support->status]) }}</span>
                                            @elseif($support->status == 'Close')
                                                <span
                                                    class="status_badge text-capitalize badge bg-danger p-2 px-3 rounded">{{ __(\App\Models\Support::$status[$support->status]) }}</span>
                                            @elseif($support->status == 'On Hold')
                                                <span
                                                    class="status_badge text-capitalize badge bg-warning p-2 px-3 rounded">{{ __(\App\Models\Support::$status[$support->status]) }}</span>
                                            @endif
                                        </td>
                                        <td>{{ \Auth::user()->dateFormat($support->created_at) }}</td>
                                        <td class="Action">
                                            <span>
                                                <div class="action-btn me-2">
                                                    <a href="{{ route('support.reply', \Crypt::encrypt($support->id)) }}"
                                                        data-title="{{ __('Support Reply') }}"
                                                        class="mx-3 btn btn-sm align-items-center bg-warning"
                                                        data-bs-toggle="tooltip" title="{{ __('Reply') }}"
                                                        data-original-title="{{ __('Reply') }}">
                                                        <i class="ti ti-corner-up-left text-white"></i>
                                                    </a>
                                                </div>
                                                @if (\Auth::user()->type == 'company' || \Auth::user()->id == $support->ticket_created)
                                                    <div class="action-btn me-2">
                                                        <a href="#" data-size="lg"
                                                            data-url="{{ route('support.edit', $support->id) }}"
                                                            data-ajax-popup="true" data-title="{{ __('Edit Support') }}"
                                                            class="mx-3 btn btn-sm align-items-center bg-info"
                                                            data-bs-toggle="tooltip" title="{{ __('Edit') }}"
                                                            data-original-title="{{ __('Edit') }}">
                                                            <i class="ti ti-pencil text-white"></i>
                                                        </a>
                                                    </div>
                                                    <div class="action-btn ">
                                                        {!! Form::open([
                                                            'method' => 'DELETE',
                                                            'route' => ['support.destroy', $support->id],
                                                            'id' => 'delete-form-' . $support->id,
                                                        ]) !!}
                                                        <a href="#!"
                                                            class="mx-3 btn btn-sm  align-items-center bs-pass-para bg-danger"
                                                            data-bs-toggle="tooltip"
                                                            data-original-title="{{ __('Delete') }}"
                                                            data-confirm="Are You Sure?|This action can not be undone. Do you want to continue?"
                                                            title="{{ __('Delete') }}"
                                                            data-confirm-yes="document.getElementById('delete-form-{{ $support->id }}').submit();">
                                                            <i class="ti ti-trash text-white"></i>
                                                        </a>
                                                        {!! Form::close() !!}
                                                    </div>
                                                @endif
                                            </span>
                                        </td>
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


