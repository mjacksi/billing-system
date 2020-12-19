@extends('manager.layout.container')
@section('style')
    <style>
        #chartdiv1, #chartdiv2, #chartdiv3, #chartdiv0 {
            width: 100%;
            height: 400px;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="kt-portlet">
            <div class="kt-portlet__body  kt-portlet__body--fit">
                <div class="row row-no-padding row-col-separator-lg">
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <!--begin::Total Profit-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title">
                                        {{ t('Posts Amount') }}
                                    </h4>
                                    <span class="kt-widget24__desc">
					            {{ t('Total Posts Amount') }}
					        </span>
                                </div>

                                <span class="kt-widget24__stats kt-font-dark">
                                    0
					    </span>
                            </div>

                        </div>
                        <!--end::Total Profit-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <!--begin::New Feedbacks-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title">
                                        {{ t('Total Payments Amount') }}
                                    </h4>
                                    <span class="kt-widget24__desc">
					            {{ t('Total Payments Amount') }}
					        </span>
                                </div>

                                <span class="kt-widget24__stats kt-font-danger">
0					    </span>
                            </div>
                        </div>
                        <!--end::New Feedbacks-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <!--begin::New Orders-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title">
                                        {{ t('Total Payments Amount') }}

                                    </h4>
                                    <span class="kt-widget24__desc">
					            {{ t('Total Orders') }}
					        </span>
                                </div>

                                <span class="kt-widget24__stats kt-font-dark">
0					    </span>
                            </div>
                        </div>
                        <!--end::New Orders-->
                    </div>
                    <div class="col-md-12 col-lg-6 col-xl-3">
                        <!--begin::New Orders-->
                        <div class="kt-widget24">
                            <div class="kt-widget24__details">
                                <div class="kt-widget24__info">
                                    <h4 class="kt-widget24__title">
                                        {{ t('Total Payments Amount') }}
                                    </h4>
                                    <span class="kt-widget24__desc">
					            {{ t('Total Pending Orders') }}
					        </span>
                                </div>

                                <span class="kt-widget24__stats kt-font-danger">
0</span>
                            </div>
                        </div>
                        <!--end::New Orders-->
                    </div>

                </div>
            </div>
        </div>
    </div>


@endsection
@section('script')
    @if(app()->getLocale() == 'ar')
        <script src="{{asset('core_ar.js')}}"></script>
    @else
        <script src="{{asset('core.js')}}"></script>
    @endif
    <script src="https://www.amcharts.com/lib/4/themes/material.js"></script>
    <script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
    <script src="https://www.amcharts.com/lib/4/lang/ar.js"></script>
@endsection
