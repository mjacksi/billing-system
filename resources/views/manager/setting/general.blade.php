@php
//    dd(\App\Models\Setting::get()->pluck('key')->all());
    $logo = optional(getSettings('logo'))->value;
    $site_name = optional(getSettings('site_name'))->value;
$address = optional(getSettings('address'))->value;

    $bannerFile = optional(getSettings('bannerFile'))->value;
    $bannerFile = isset($bannerFile)? asset($bannerFile) : null;


    $adFile = optional(getSettings('adFile'))->value;
    $adFile = isset($adFile)? asset($adFile) : null;

    $occasions = optional(getSettings('occasions'))->value;
    $occasions = isset($occasions)? asset($occasions) : null;
    $about_us_footer = optional(getSettings('about_us_footer'))->value;
    $facebook = optional(getSettings('facebook'))->value;
    $twitter = optional(getSettings('twitter'))->value;
    $instagram = optional(getSettings('instagram'))->value;
    $youtube = optional(getSettings('youtube'))->value;
    $linkedin = optional(getSettings('linkedin'))->value;
    $email = optional(getSettings('email'))->value;
    $phone = optional(getSettings('phone'))->value;
    $about_us_image = optional(getSettings('about_us_image'))->value;
    $footer_long_description = optional(getSettings('footer_long_description'))->value;
    $facebook_likes = optional(getSettings('facebook_likes'))->value;
    $twitter_likes = optional(getSettings('twitter_likes'))->value;
    $youtube_likes = optional(getSettings('youtube_likes'))->value;

@endphp

@extends('manager.layout.container')
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            {{ t('General Settings') }}
        </li>
    @endpush

@section('style')
    <link href="{{ asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet"
          type="text/css"/>
    <style>
        .label-info {
            background-color: #5bc0de;
        }

        .bootstrap-tagsinput .tag {
            margin-right: 2px;
            color: white;
        }

        .label {
            display: inline;
            padding: .2em .6em .3em;
            font-size: 75%;
            font-weight: 700;
            line-height: 1;
            color: #fff;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: .25em;
        }
    </style>

    <link href="{{ asset('assets/vendors/general/summernote/dist/summernote.rtl.css') }}" rel="stylesheet"/>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">

@endsection


<div class="row">
    <div class="col-xl-12">
        <div class="kt-portlet">
            <div class="kt-portlet__head">
                <div class="kt-portlet__head-label">
                    <h3 class="kt-portlet__head-title">
                        <i class="flaticon-responsive"></i> {{ t('General Settings') }}</h3>
                </div>
            </div>
            <form id="form_information" class="kt-form kt-form--label-right" enctype="multipart/form-data"
                  action="{{ route('manager.settings.updateSettings') }}" method="post">
                {{ csrf_field() }}
                <div class="kt-portlet__body">
                    <div class="kt-section kt-section--first">
                        <div class="kt-section__body">
                            <div class="row">
                                <div class="col-md-12">
                                    <!--begin::Portlet-->
                                    <div class="m-portlet ">
                                        <div class="m-portlet__body">
                                            <ul class="nav nav-pills" role="tablist">
                                                <li class="nav-item">
                                                    <a class="nav-link active" data-toggle="tab"
                                                       href="#m_general-settings">{{t('general_settings')}}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                       href="#social_media">{{t('social_media')}}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                       href="#contact_us">{{t('contact_us')}}</a>
                                                </li>

                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                       href="#about_us_us">{{t('about_us')}}</a>
                                                </li>


                                                <li class="nav-item">
                                                    <a class="nav-link" data-toggle="tab"
                                                       href="#likes">{{t('likes')}}</a>
                                                </li>

                                            </ul>
                                            <div class="tab-content">
                                                @include('manager.setting.include.general-settings.index')
                                                @include('manager.setting.include.social-media.index')
                                                @include('manager.setting.include.contact-us.index')
                                                @include('manager.setting.include.about_us.index')
                                                @include('manager.setting.include.likes.index')
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <div class="kt-portlet__foot">
                    <div class="kt-form__actions">
                        <div class="row">
                            <div class="col-lg-12 text-right">
                                <button type="submit" class="btn btn-brand">{{ t('Save') }}</button>&nbsp;
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection

@section('script')
    <script src="{{ asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}"
            type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script>
        $(document).ready(function () {
            $("form").keypress(function (e) {
                //Enter key
                if (e.which == 13) {
                    return false;
                }
            });
        });
    </script>


    <script src="{{ asset('assets/vendors/general/summernote/dist/summernote.min.js') }}"
            type="text/javascript"></script>
    <script>
        $(document).ready(function () {
            $('.summernote').summernote({
                height: '300px',
            });
        });

        $(function () {
            $('.selectpicker').selectpicker({
                title: "{{t('Select Categories')}}",
                liveSearch: true,
                noneResultsText: "{{t('No results matched')}}"
            });
        });

    </script>


    {!! $validator->selector('#form_information') !!}
@endsection

