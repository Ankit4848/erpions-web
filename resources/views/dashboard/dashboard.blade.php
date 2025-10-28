@extends('layouts.admin')
@section('page-title')
    {{__('Dashboard')}}
@endsection
@push('script-page')
    <script>
        $(document).ready(function()
        {
            get_data();
        });

        function get_data()
        {
            var calender_type=$('#calender_type :selected').val();
            $('#calendar').removeClass('local_calender');
            $('#calendar').removeClass('goggle_calender');
            if(calender_type==undefined){
                $('#calendar').addClass('local_calender');
            }
            $('#calendar').addClass(calender_type);
            $.ajax({
                url: $("#event_dashboard").val()+"/event/get_event_data" ,
                method:"POST",
                data: {"_token": "{{ csrf_token() }}",'calender_type':calender_type},
                success: function(data) {
                    (function () {
                        var etitle;
                        var etype;
                        var etypeclass;
                        var calendar = new FullCalendar.Calendar(document.getElementById('calendar'), {
                            headerToolbar: {
                                left: 'prev,next today',
                                center: 'title',
                                right: 'timeGridDay,timeGridWeek,dayGridMonth'
                            },
                            buttonText: {
                                timeGridDay: "{{__('Day')}}",
                                timeGridWeek: "{{__('Week')}}",
                                dayGridMonth: "{{__('Month')}}"
                            },
                            slotLabelFormat: {
                                hour: '2-digit',
                                minute: '2-digit',
                                hour12: false,
                            },
                            themeSystem: 'bootstrap',
                            navLinks: true,
                            droppable: true,
                            selectable: true,
                            selectMirror: true,
                            editable: true,
                            dayMaxEvents: true,
                            handleWindowResize: true,
                            height: 'auto',
                            timeFormat: 'H(:mm)',
                            {{--events: {!! json_encode($arrEvents) !!},--}}
                            events: data,
                            locale: '{{basename(App::getLocale())}}',
                            dayClick: function (e) {
                                var t = moment(e).toISOString();
                                $("#new-event").modal("show"), $(".new-event--title").val(""), $(".new-event--start").val(t), $(".new-event--end").val(t)
                            },
                            eventResize: function (event) {
                                var eventObj = {
                                    start: event.start.format(),
                                    end: event.end.format(),
                                };
                            },
                            viewRender: function (t) {
                                e.fullCalendar("getDate").month(), $(".fullcalendar-title").html(t.title)
                            },
                            eventClick: function (e, t) {
                                var title = e.title;
                                var url = e.url;

                                if (typeof url != 'undefined') {
                                    $("#commonModal .modal-title").html(title);
                                    $("#commonModal .modal-dialog").addClass('modal-md');
                                    $("#commonModal").modal('show');
                                    $.get(url, {}, function (data) {
                                        $('#commonModal .modal-body').html(data);
                                    });
                                    return false;
                                }
                            }
                        });
                        calendar.render();
                    })();
                }
            });
        }
    </script>
@endpush
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{route('dashboard')}}">{{__('Dashboard')}}</a></li>
    <li class="breadcrumb-item">{{__('HRM')}}</li>
@endsection
@php
    $setting = \App\Models\Utility::settings();
@endphp
@section('content')
    @if(\Auth::user()->type != 'client' && \Auth::user()->type != 'company')
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xxl-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>{{__('Mark Attandance')}}</h5>
                            </div>
                            <div class="card-body dash-card-body">
                                <p>{{__('My Office Time: '.$officeTime['startTime'].' to '.$officeTime['endTime'])}}</p>
                                <center>
                                    <div class="row">
                                        <div class="col-md-6">
                                            {{Form::open(array('url'=>'attendanceemployee/attendance','method'=>'post'))}}
                                            @if(empty($employeeAttendance) || $employeeAttendance->clock_out != '00:00:00')
                                                <button type="submit" value="0" name="in" id="clock_in" class="btn btn-success ">{{__('CLOCK IN')}}</button>
                                            @else
                                                <button type="submit" value="0" name="in" id="clock_in" class="btn btn-success disabled" disabled>{{__('CLOCK IN')}}</button>
                                            @endif
                                            {{Form::close()}}
                                        </div>
                                        <div class="col-md-6 ">
                                            @if(!empty($employeeAttendance) && $employeeAttendance->clock_out == '00:00:00')
                                                {{Form::model($employeeAttendance,array('route'=>array('attendanceemployee.update',$employeeAttendance->id),'method' => 'PUT')) }}
                                                <button type="submit" value="1" name="out" id="clock_out" class="btn btn-danger">{{__('CLOCK OUT')}}</button>
                                            @else
                                                <button type="submit" value="1" name="out" id="clock_out" class="btn btn-danger disabled" disabled>{{__('CLOCK OUT')}}</button>
                                            @endif
                                            {{Form::close()}}
                                        </div>
                                    </div>
                                </center>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>{{ __('Event') }}</h5>
                                    </div>
                                    <div class="col-lg-6">
                                        @if (isset($setting['google_calendar_enable']) && $setting['google_calendar_enable'] == 'on')
                                        <select class="form-control" name="calender_type" id="calender_type" onchange="get_data()">
                                            <option value="goggle_calender">{{__('Google Calender')}}</option>
                                            <option value="local_calender" selected="true">{{__('Local Calender')}}</option>
                                        </select>
                                        @endif
                                        <input type="hidden" id="event_dashboard" value="{{url('/')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id='calendar' class='calendar e-height'></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-6">
                        <div class="card list_card">
                            <div class="card-header">
                                <h5>{{__('Announcement List')}}</h5>
                            </div>
                            <div class="card-body dash-card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                        <tr>
                                            <th>{{__('Title')}}</th>
                                            <th>{{__('Start Date')}}</th>
                                            <th>{{__('End Date')}}</th>
                                            <th>{{__('description')}}</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($announcements as $announcement)
                                            <tr>
                                                <td>{{ $announcement->title }}</td>
                                                <td>{{ \Auth::user()->dateFormat($announcement->start_date)  }}</td>
                                                <td>{{ \Auth::user()->dateFormat($announcement->end_date) }}</td>
                                                <td>{{ $announcement->description }}</td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="4">
                                                    <div class="text-center">
                                                        <h6>{{__('There is no Announcement List')}}</h6>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="card list_card">
                            <div class="card-header">
                                <h5>{{__('Meeting List')}}</h5>
                            </div>
                            <div class="card-body dash-card-body">
                                @if(count($meetings) > 0)
                                    <div class="table-responsive">
                                        <table class="table align-items-center">
                                            <thead>
                                            <tr>
                                                <th>{{__('Meeting title')}}</th>
                                                <th>{{__('Meeting Date')}}</th>
                                                <th>{{__('Meeting Time')}}</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @forelse($meetings as $meeting)
                                                <tr>
                                                    <td>{{ $meeting->title }}</td>
                                                    <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                                    <td>{{ \Auth::user()->timeFormat($meeting->time) }}</td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <div class="p-2">
                                        {{__('No meeting scheduled yet.')}}
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-xxl-12">
                <div class="card">
                    <div class="card-header">
                        <h5>{{__("Today's Not Clock In")}}</h5>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="d-flex gap-1 team-lists horizontal-scroll-cards">
                                    @foreach($notClockIns as $notClockIn)
                                    @php
                                        $user = $notClockIn->user;
                                        $logo= asset(Storage::url('uploads/avatar/'));
                                        $avatar = !empty($notClockIn->user->avatar) ? $notClockIn->user->avatar : 'avatar.png';
                                    @endphp
                                        <div>
                                            <img src="{{ $logo . $avatar }}" alt="" class="rounded-5 border-1 border border-primary">
                                            <p class="mt-2 mb-1 p-0">{{ $notClockIn->name }}</p>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-xl-6 mb-4">
                        <div class="card h-100 mb-0">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <h5>{{ __('Event') }}</h5>
                                    </div>
                                    <div class="col-lg-6">

                                        @if(isset($setting['google_calendar_enable']) && $setting['google_calendar_enable'] == 'on')
                                            <select class="form-control" name="calender_type" id="calender_type" onchange="get_data()">
                                                <option value="goggle_calender">{{__('Google Calender')}}</option>
                                                <option value="local_calender" selected="true">{{__('Local Calender')}}</option>
                                            </select>
                                        @endif
                                        <input type="hidden" id="event_dashboard" value="{{url('/')}}">
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div id='calendar' class='calendar'></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6">
                        <div class="col-xxl-12">
                            <div class="card staff-info-card-wrp">
                                <div class="card-header">
                                    <h5>{{__('Staff')}}</h5>
                                </div>
                                <div class="card-body p-3">
                                   
                                    <div class="row row-gap-1">
                                        <div class="col-xxl-4 col-xl-12 col-md-4 col-sm-6 col-12 staff-info-card">
                                            <div class="staff-info-inner d-flex align-items-center gap-3">
                                                <img  src="{{ asset('assets/images/design-images/All/Acc-ts.svg') }}"  alt="">
                                                <div class="staff-info">
                                                    <p class="mb-1 dashboard-link">{{__('Total Staff')}}</p>
                                                    <h4 class="mb-0">{{ $countUser +   $countClient}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-12 col-md-4 col-sm-6 col-12 staff-info-card">
                                            <div class="staff-info-inner d-flex align-items-center gap-3">
                                                <img  src="{{ asset('assets/images/design-images/All/Acc-te.svg') }}"  alt="">
                                               
                                                <div class="staff-info">
                                                    <p class="mb-1">
                                                        <a href="{{ route('employee.index') }}" class="dashboard-link">{{__('Total Employee')}}</a>
                                                    </p>
                                                    <h4 class="mb-0">{{$countUser}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-12 col-md-4 col-sm-6 col-12 staff-info-card">
                                            <div class="staff-info-inner d-flex align-items-center gap-3">
                                                <img  src="{{ asset('assets/images/design-images/All/Acc-tc.svg') }}"  alt="">
                                                <div class="staff-info">
                                                    <p class="mb-1">
                                                        <a href="{{ route('clients.index') }}" class="dashboard-link">{{__('Total Client')}}</a>
                                                    </p>
                                                    <h4 class="mb-0">{{$countClient}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card staff-info-card-wrp">
                                 <div class="card-header">
                                    <h5>{{__('Job')}}</h5>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row row-gap-1">
                                        <div class="col-xxl-4 col-xl-12 col-md-4 col-sm-6 col-12 staff-info-card">
                                            <div class="staff-info-inner d-flex align-items-center gap-3">
                                               <img  src="{{ asset('assets/images/design-images/All/Acc-tj.svg') }}"  alt="">
                                                <div class="staff-info">
                                                    <p class="mb-1">
                                                        <a href="{{ route('job.index') }}" class="dashboard-link">{{__('Total Jobs')}}</a>
                                                    </p>
                                                    <h4 class="mb-0">{{$activeJob + $inActiveJOb}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-12 col-md-4 col-sm-6 col-12 staff-info-card">
                                            <div class="staff-info-inner d-flex align-items-center gap-3">
                                               <img  src="{{ asset('assets/images/design-images/All/Acc-aj.svg') }}"  alt="">
                                                <div class="staff-info">
                                                    <p class="mb-1 dashboard-link">{{__('Active Jobs')}}</p>
                                                    <h4 class="mb-0">{{$activeJob}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-12 col-md-4 col-sm-6 col-12 staff-info-card">
                                            <div class="staff-info-inner d-flex align-items-center gap-3">
                                              <img  src="{{ asset('assets/images/design-images/All/Acc-ij.svg') }}"  alt="">
                                                <div class="staff-info">
                                                    <p class="mb-1 dashboard-link">{{__('Inactive Jobs')}}</p>
                                                    <h4 class="mb-0">{{$inActiveJOb}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card staff-info-card-wrp">
                               
                                <div class="card-header">
                                    <h5>{{__('Training')}}</h5>
                                </div>
                                <div class="card-body p-3">
                                    <div class="row row-gap-1">
                                        <div class="col-xxl-4 col-xl-12 col-md-4 col-sm-6 col-12 staff-info-card">
                                            <div class="staff-info-inner d-flex align-items-center gap-3">
                                                <img  src="{{ asset('assets/images/design-images/All/Acc-t.svg') }}"  alt="">
                                                <div class="staff-info">
                                                    <p class="mb-1">
                                                        <a href="{{ route('trainer.index') }}" class="dashboard-link">{{__('Trainer')}}</a>
                                                    </p>
                                                    <h4 class="mb-0">{{$countTrainer}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-12 col-md-4 col-sm-6 col-12 staff-info-card">
                                            <div class="staff-info-inner d-flex align-items-center gap-3">
                                                 <img  src="{{ asset('assets/images/design-images/All/Acc-at.svg') }}"  alt="">
                                                <div class="staff-info">
                                                    <p class="mb-1 dashboard-link">{{__('Active Training')}}</p>
                                                    <h4 class="mb-0">{{$onGoingTraining}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-xxl-4 col-xl-12 col-md-4 col-sm-6 col-12 staff-info-card">
                                            <div class="staff-info-inner d-flex align-items-center gap-3">
                                                 <img  src="{{ asset('assets/images/design-images/All/Acc-dt.svg') }}"  alt="">
                                                <div class="staff-info">
                                                    <p class="mb-1 dashboard-link">{{__('Done Training')}}</p>
                                                    <h4 class="mb-0">{{$doneTraining}}</h4>
                                                </div>
                                            </div>
                                        </div>
                                      
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12">
                            <div class="card h-100 mb-0">
                                                <div class="card-header">

                                                    <h5>{{__('Announcement List')}}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        @if(count($announcements) > 0)
                                                            <table class="table align-items-center">
                                                                <thead>
                                                                <tr>
                                                                    <th>{{__('Title')}}</th>
                                                                    <th>{{__('Start Date')}}</th>
                                                                    <th>{{__('End Date')}}</th>

                                                                </tr>
                                                                </thead>
                                                                <tbody class="list">
                                                                @foreach($announcements as $announcement)
                                                                    <tr>
                                                                        <td>{{ $announcement->title }}</td>
                                                                        <td>{{ \Auth::user()->dateFormat($announcement->start_date) }}</td>
                                                                        <td>{{ \Auth::user()->dateFormat($announcement->end_date) }}</td>

                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <div class="p-2 text-center">
                                                                {{__('No accouncement present yet.')}}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                            </div>
                        </div>
                        <div class="col-xxl-12 mt-4">
                                            <div class="card h-100 mb-0">
                                                <div class="card-header">
                                                    <h5>{{__('Meeting schedule')}}</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="table-responsive">
                                                        @if(count($meetings) > 0)
                                                            <table class="table align-items-center">
                                                                <thead>
                                                                <tr>
                                                                    <th>{{__('Title')}}</th>
                                                                    <th>{{__('Date')}}</th>
                                                                    <th>{{__('Time')}}</th>
                                                                </tr>
                                                                </thead>
                                                                <tbody class="list">
                                                                @foreach($meetings as $meeting)
                                                                    <tr>
                                                                        <td>{{ $meeting->title }}</td>
                                                                        <td>{{ \Auth::user()->dateFormat($meeting->date) }}</td>
                                                                        <td>{{  \Auth::user()->timeFormat($meeting->time) }}</td>
                                                                    </tr>
                                                                @endforeach
                                                                </tbody>
                                                            </table>
                                                        @else
                                                            <div class="p-2 text-center">
                                                                {{__('No meeting scheduled yet.')}}
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                        </div>             
                    </div>
                   
                </div>
            </div>

        </div>
    @endif
@endsection


