@php
    $lang = isset($curr_noti_tempLang->lang) ? $curr_noti_tempLang->lang : 'en';
    if ($lang == null) {
        $lang = 'en';
    }

    $user = \App\Models\User::find(\Auth::user()->creatorId());
    $plan= \App\Models\Plan::getPlan($user->plan);
@endphp
@extends('layouts.admin')
@section('page-title')
    {{ $notification_template->name }}
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ __('Dashboard') }}</a></li>
    <li class="breadcrumb-item active" aria-current="page">{{ __('Notification Template') }}</li>
@endsection
@push('pre-purpose-css-page')
    <link rel="stylesheet" href="{{asset('css/summernote/summernote-bs4.css')}}">
@endpush

@section('action-btn')
@endsection
@section('content')
    @if ($plan->chatgpt == 1)
        <div class="text-end mb-3">
            <a href="#" class="generate-btn" data-size="medium" data-ajax-popup-over="true"
                data-url="{{ route('generate', ['notification template']) }}" data-bs-toggle="tooltip"
                data-bs-placement="top" title="{{ __('Generate') }}" data-title="{{ __('Generate Content With AI') }}">
               <img src="{{ asset('assets/images/design-images/All/gtenerate.svg') }}" alt="Generate With AI">{{ __(' Generate With AI') }}
            </a>
        </div>
    @endif

    <div class="row">
        <div class="col-md-12 col-12">
            <div class="new-box-table-shadow1 card ">
                <div class="card-header card-body" style="border-bottom: none;">
                    <h5 class="mb-4"> {{ __('Variables') }}</h5>
                    <div class="row text-xs">

                        <!-- <h6 class="font-weight-bold mb-4">{{ __('Variables') }}</h6> -->
                        @php
                            $variables = json_decode($curr_noti_tempLang->variables);
                        @endphp
                        @if (!empty($variables) > 0)
                            @foreach ($variables as $key => $var)
                                <div class="col-6 pb-1">
                                    <p class="mb-1 label-title">{{ __($key) }} : <span
                                            class="pull-right text-primary label-detail">{{ '{' . $var . '}' }}</span></p>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
        <div class="col-12">
            <h5></h5>
            <div class="row">
                <div class="col-sm-3 col-md-3 col-lg-3 col-xl-3 ">
                    <div class="new-box-table-shadow2 sticky-top language-sidebar mb-0">
                        <div class="list-group list-group-flush" id="useradd-sidenav">
                            @foreach ($languages as $key => $lang)
                                <a class="list-group-item list-group-item-action new-border-bts {{ $curr_noti_tempLang->lang == $key ? 'active' : '' }}"
                                    href="{{ route('manage.notification.language', [$notification_template->id, $key]) }}">
                                    {{ Str::ucfirst($lang) }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="col-lg-9 col-md-9 col-sm-9">
                    <div class="h-100">
                        {{ Form::model($curr_noti_tempLang, ['route' => ['notification-templates.update', $curr_noti_tempLang->parent_id], 'method' => 'PUT']) }}
                        <div class="row">
                         <div class="new-box-table-shadow2 h-500 p-3 ">
                               <div class="form-group col-12">
                                {{ Form::label('name', __('Name'), ['class' => 'col-form-label text-dark']) }}
                                {{ Form::text('name', $notification_template->name, ['class' => 'form-control font-style', 'disabled' => 'disabled']) }}
                            </div>
                            <div class="form-group col-12">
                                {{ Form::label('content', __('Notification Message'), ['class' => 'col-form-label text-dark']) }}
                                {{ Form::textarea('content', $curr_noti_tempLang->content, ['class' => 'form-control font-style', 'required' => 'required']) }}
                            </div>
                         </div>
                        </div>
                        <div class="col-md-12 text-end mt-3">
                            {{ Form::hidden('lang', null) }}
                            <input type="submit" value="{{ __('Save') }}"
                                class="btn btn-print-invoice  btn-primary">
                        </div>
                        {{ Form::close() }}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

