@extends('accountant.layout.container')
@section('style')
    <link href="{{ asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection


@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('accountant.payments.index') }}">{{t('payments')}}</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($payments) ? t('Edit payments') : t('Add payments') }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ isset($payments) ? t('Edit payments') : t('Add payments') }}</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="form_information" class="kt-form kt-form--label-right"
                      action="{{route('accountant.payments.store') }}" method="post">
                    {{ csrf_field() }}
                    @if(isset($payments))
                        <input type="hidden" name="payments_id" value="{{$payments->id}}">
                    @endif


                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Cost') }}</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input name="amount" type="number" step="1" class="form-control"
                                               value="{{isset($payments)?$payments->amount : ''}}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit"
                                            class="btn btn-danger">{{ isset($payments) ? t('Update'):t('Create') }}</button>&nbsp;
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


            $('#has_number').on('change', function () {
                if (this.checked) {
                    $('#number').show();
                } else {

                    $('#number').hide();
                }
            });

        });

    </script>
    {!! $validator->selector('#form_information') !!}
@endsection
