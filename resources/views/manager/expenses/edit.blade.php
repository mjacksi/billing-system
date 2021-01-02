@extends('manager.layout.container')
@section('style')
    <link href="{{ asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection


@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route_admin('expenses.index') }}">{{t('Expenses')}}</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($expense) ? t('Edit Expenses') : t('Add Expenses') }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ isset($expense) ? t('Edit Expenses') : t('Add Expenses') }}</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="form_information" class="kt-form kt-form--label-right"
                      action="{{route_admin('expenses.store') }}" method="post">
                    {{ csrf_field() }}
                    @if(isset($expense))
                        <input type="hidden" name="expense_id" value="{{$expense->id}}">
                    @endif


                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Title') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="title" type="text"
                                               value="{{ isset($expense) ? $expense->title : old("title") }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Cost') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="cost" type="number"
                                               value="{{ isset($expense) ? $expense->cost : old("cost") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Details') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <textarea name="details" id="details" cols="30" rows="10"
                                                  class="form-control">{{ isset($expense) ? $expense->details : old("details") }}</textarea>
                                    </div>
                                </div>

{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-3 col-form-label font-weight-bold">{{t('Draft')}}</label>--}}
{{--                                    <div class="col-3">--}}
{{--                                        <span class="kt-switch">--}}
{{--                                            <label>--}}
{{--                                            <input type="checkbox" value="1"--}}
{{--                                                   {{ isset($expense) && $expense->draft == 1 ? 'checked' :'' }} name="draft">--}}
{{--                                            <span></span>--}}
{{--                                            </label>--}}
{{--                                        </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit"
                                            class="btn btn-danger">{{ isset($expense) ? t('Update'):t('Create') }}</button>&nbsp;
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
    {!! $validator->selector('#form_information') !!}
@endsection
