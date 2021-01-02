@extends('manager.layout.container')
@section('style')
    <link href="{{ asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection


@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route_admin('cds.index') }}">{{t('cds')}}</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($cds) ? t('Edit cds') : t('Add cds') }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ isset($cds) ? t('Edit cds') : t('Add cds') }}</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data"
                      id="form_information"
                      class="kt-form kt-form--label-right"
                      action="{{route_admin('cds.store') }}" method="post">
                    {{ csrf_field() }}
                    @if(isset($cds))
                        <input type="hidden" name="cds_id" value="{{$cds->id}}">
                    @endif


                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Name') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <select name="client" class="form-control">
                                            <option value=''>{{t('Select Client')}}</option>
                                            @foreach($users as $key2=>$item2)
                                                <option value="{{$item2->id}}"{{isset($cds) &&$item2->id == $cds->user_id? 'selected' : ''}}>  {{$item2->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Type') }} </label>--}}
{{--                                    <div class="col-lg-9 col-xl-6">--}}
{{--                                        <select name="type" class="form-control">--}}
{{--                                            <option value=''>{{t('Select Type')}}</option>--}}
{{--                                            <option value='{{\App\Models\CDs::CREDITOR}}' {{isset($cds) && $cds->type == \App\Models\CDs::CREDITOR? 'selected' : ''}}>{{t('Creditor')}}</option>--}}
{{--                                            <option value='{{\App\Models\CDs::DEBTOR}}' {{isset($cds) && $cds->type == \App\Models\CDs::DEBTOR? 'selected' : ''}}>{{t('Debtor')}}</option>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}


                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Cost') }}</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input name="cost" type="number" step="1" class="form-control"
                                               value="{{isset($cds)?$cds->amount : ''}}">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Note') }}</label>
                                    <div class="col-lg-9 col-xl-6">
                                        <textarea name="note" id="" cols="30" rows="10"
                                                  class="form-control">{{isset($cds)? $cds->note : ''}}</textarea>
                                    </div>
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit" class="btn btn-danger">{{ isset($cds) ? t('Update'):t('Create') }}</button>&nbsp;
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
