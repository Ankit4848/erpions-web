@extends('layouts.admin')
@php
    $profile=\App\Models\Utility::get_file('uploads/avatar/');
@endphp
@section('page-title')
    {{__('Profile Account')}}
@endsection
@push('script-page')
    <script>
        var scrollSpy = new bootstrap.ScrollSpy(document.body, {
            target: '#useradd-sidenav',
            offset: 300,
        })
        $(".list-group-item").click(function(){
            $('.list-group-item').filter(function(){
                return this.href == id;
            }).parent().removeClass('text-primary');
        });
    </script>

    <script>
        document.getElementById('avatar').onchange = function () {
            var src = URL.createObjectURL(this.files[0])
            document.getElementById('image').src = src
        }
        </script>

    <script>
            document.querySelectorAll(".profile-new-tab .tab-item").forEach((item) => {
            item.addEventListener("click", function () {
                document.querySelector(".tab-item.active").classList.remove("active");
                this.classList.add("active");

                let tabId = this.getAttribute("data-tab");

                document.querySelector(".tab-content.active").classList.remove("active");
                document.querySelector(`#${tabId}`).classList.add("active");
            });
        });
    </script>
@endpush

@section('content')
    <!-- <div class="row">
        <div class="col-xl-3">
            <div class="card sticky-top" style="top:30px">
                <div class="list-group list-group-flush" id="useradd-sidenav">
                    <a href="#personal_info" class="list-group-item list-group-item-action border-0">{{__('Personal Info')}} <div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                    <a href="#change_password" class="list-group-item list-group-item-action border-0">{{__('Change Password')}}<div class="float-end"><i class="ti ti-chevron-right"></i></div></a>
                </div>
            </div>
        </div>
        <div class="col-xl-9">
            <div id="personal_info" class="card">
                <div class="card-header">
                    <h5>{{__('Personal Info')}}</h5>
                </div>
                    <div class="card-body">
                    {{Form::model($userDetail,array('route' => array('update.account'), 'method' => 'post', 'enctype' => "multipart/form-data"))}}
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <label class="col-form-label text-dark">{{__('Name')}}</label>
                                    <input class="form-control" name="name" type="text" id="name" placeholder="{{ __('Enter Your Name') }}" value="{{ $userDetail->name }}" required autocomplete="name">
                                </div>
                            </div>
                            <div class="col-lg-6 col-sm-6">
                                <div class="form-group">
                                    <label for="email" class="col-form-label text-dark">{{__('Email')}}</label>
                                    <input class="form-control" name="email" type="email" id="email" placeholder="{{ __('Enter Your Email Address') }}" value="{{ $userDetail->email }}" required autocomplete="email">
                                </div>
                            </div>
                            <div class="col-lg-6 col-md-6">
                                <div class="form-group">
                                    <div class="theme-avtar-logo mt-4">
                                        <img id="image" src="{{ ($userDetail->avatar) ? $profile  . $userDetail->avatar : $profile . 'avatar.png' }}"
                                             class="big-logo">
                                    </div>
                                    <div class="choose-files mt-3">
                                        <label for="avatar">
                                            <div class=" bg-primary profile_update"> <i class="ti ti-upload px-1"></i>{{__('Choose file here')}}</div>
                                            <input type="file" class="form-control file file-validate" name="profile" id="avatar" data-filename="profile_update">
                                            <p id="" class="file-error text-danger"></p>
                                        </label>
                                    </div>
                                    <span class="text-xs text-muted">{{ __('Please upload a valid image file. Size of image should not be more than 2MB.')}}</span>
                                </div>

                            </div>
                            <div class="col-lg-12 text-end">
                                <input type="submit" value="{{__('Save Changes')}}" class="btn btn-print-invoice  btn-primary m-r-10">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
            <div id="change_password" class="card">
                <div class="card-header">
                    <h5>{{__('Change Password')}}</h5>
                </div>
                <div class="card-body">
                    <form method="post" action="{{route('update.password')}}">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-sm-6 form-group">
                                <label for="old_password" class="col-form-label text-dark">{{ __('Old Password') }}</label>
                                <input class="form-control" name="old_password" type="password" id="old_password" required autocomplete="old_password" placeholder="{{ __('Enter Old Password') }}">
                            </div>

                            <div class="col-lg-6 col-sm-6 form-group">
                                <label for="password" class="col-form-label text-dark">{{ __('New Password') }}</label>
                                <input class="form-control" name="password" type="password" required autocomplete="new-password" id="password" placeholder="{{ __('Enter Your New Password') }}">
                            </div>
                            <div class="col-lg-6 col-sm-6 form-group">
                                <label for="password_confirmation" class="col-form-label text-dark">{{ __('New Confirm Password') }}</label>
                                <input class="form-control" name="password_confirmation" type="password" required autocomplete="new-password" id="password_confirmation" placeholder="{{ __('Enter Your Confirm Password') }}">
                            </div>
                            <div class="col-lg-12 text-end">
                                <input type="submit" value="{{__('Change Password')}}" class="btn btn-print-invoice  btn-primary m-r-10">
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div> -->

    <div class="profile-new-tab mt-3">
        <ul class="main-home-tab-container ">
            <li class="main-home-tab tab-item active" data-tab="personal-info">Personal Info</li>
            <li class="main-home-tab tab-item" data-tab="change-password">Change Password</li>
        </ul>

        <div class="main-home-tab-content tab-content active" id="personal-info">
             <div id="personal_info" class="card new-box-table-shadow1">
               
                    <div class="card-body ">
                    {{Form::model($userDetail,array('route' => array('update.account'), 'method' => 'post', 'enctype' => "multipart/form-data"))}}
                        @csrf
                        <div class="row">
                           <div class="col-lg-3">
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label class="col-form-label text-dark">{{__('Name')}}</label>
                                        <input class="form-control" name="name" type="text" id="name" placeholder="{{ __('Enter Your Name') }}" value="{{ $userDetail->name }}" required autocomplete="name">
                                    </div>
                                </div>
                                <div class="col-lg-12 col-sm-12">
                                    <div class="form-group">
                                        <label for="email" class="col-form-label text-dark">{{__('Email')}}</label>
                                        <input class="form-control" name="email" type="email" id="email" placeholder="{{ __('Enter Your Email Address') }}" value="{{ $userDetail->email }}" required autocomplete="email">
                                    </div>
                                </div>
                           </div>
                           <div class="col-lg-1 up-lines-pro-main">
                            <div class="up-lines-pro"></div>
                           </div>
                           <div class="col-lg-8 btn-rights">
                                <div >
                                    <div class="form-group">
                                       <div class="p-i-main-page">
                                            <div>
                                                <img id="image" src="{{ ($userDetail->avatar) ? $profile  . $userDetail->avatar : $profile . 'avatar.png' }}"
                                                    class="big-logo" >
                                            </div>
                                            <div class="choose-files">
                                                <label for="avatar">
                                                    <div class="new-profile-update"> 
                                                        <i class="ti ti-upload px-1"></i>
                                                        {{__('Choose file here')}}
                                                    </div>
                                                    <input type="file" class="form-control file file-validate" name="profile" id="avatar" data-filename="profile_update">
                                                    <p id="" class="file-error text-danger"></p>
                                                </label>
                                            </div>
                                       </div>
                                        <span style="color: #515151; font-size: 12px;">{{ __('Please upload a valid image file. Size of image should not be more than 2MB.')}}</span>
                                    </div>
                                </div>
                                <div class="text-end">
                                    <input type="submit" value="{{__('Save Changes')}}" class="border-radius-10 btn btn-print-invoice   btn-primary m-r-10">
                                </div>
                           </div> 
                        </div>
                    </form>
                </div>

            </div>
        </div>

        <div class="main-home-tab-content tab-content" id="change-password">
            <div id="change_password" class="card new-box-table-shadow1">
               
                <div class="card-body">
                    <form method="post" action="{{route('update.password')}}">
                        @csrf
                        <div class="row">
                           
                        
                            <div class="col-3">
                                <div class=" form-group">
                                    <label for="old_password" class="col-form-label text-dark">{{ __('Old Password') }}</label>
                                    <input class="form-control" name="old_password" type="password" id="old_password" required autocomplete="old_password" placeholder="{{ __('Enter Old Password') }}">
                                </div>

                                <div class="form-group">
                                    <label for="password" class="col-form-label text-dark">{{ __('New Password') }}</label>
                                    <input class="form-control" name="password" type="password" required autocomplete="new-password" id="password" placeholder="{{ __('Enter Your New Password') }}">
                                </div>
                            </div>
                            <div class="col-1"></div>
                            <div class="col-8 btn-rights">
                                    <div class="col-4 form-group">
                                <label for="password_confirmation" class="col-form-label text-dark">{{ __('New Confirm Password') }}</label>
                                <input class="form-control" name="password_confirmation" type="password" required autocomplete="new-password" id="password_confirmation" placeholder="{{ __('Enter Your Confirm Password') }}">
                            </div>
                            <div class="col-lg-12 text-end">
                                <input type="submit" value="{{__('Change Password')}}" class="border-radius-10 btn btn-print-invoice  btn-primary m-r-10">
                            </div>
                            </div>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>


@endsection


