@extends('manager.layout.container')
@section('style')
    <link href="{{ asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route_admin('items.index') }}">{{t('items')}}</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($items) ? t('Edit items') : t('Add items') }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ isset($items) ? t('Edit items') : t('Add items') }}</h3>
                    </div>
                </div>
                    <form enctype="multipart/form-data" id="form_information" class="kt-form kt-form--label-right"
                          action="{{route_admin('items.store') }}" method="post">
                        {{ csrf_field() }}
                        @if(isset($items))
                            <input type="hidden" name="items_id" value="{{$items->id}}">
                        @endif



                        <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Name') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="name" type="text"
                                               value="{{ isset($items) ? $items->name : old("name") }}">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Unit') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="unit" type="text"
                                               value="{{ isset($items) ? $items->unit : old("unit") }}">
                                    </div>
                                </div>


                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Cost Before') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="cost_before" type="number"
                                               value="{{ isset($items) ? $items->cost_before : old("cost_before") }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Cost After') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="cost_after" type="number"
                                               value="{{ isset($items) ? $items->cost_after : old("cost_after") }}">
                                    </div>
                                </div>


                                <div class="form-group row" id="number" style="display:  {{isset($items) && $items->hasNumber == YES ? '' : 'none'}}">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Number') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="number" type="number"
                                               value="{{ isset($items) ? $items->number : old("number") }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label font-weight-bold">{{t('Has Number')}}</label>
                                    <div class="col-3">
                                        <span class="kt-switch">
                                            <label>
                                            <input type="checkbox" value="1"  {{ isset($items) && $items->hasNumber == YES ? 'checked' :'' }} name="has_number" id="has_number">
                                            <span></span>
                                            </label>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-3 col-form-label font-weight-bold">{{t('Draft')}}</label>
                                    <div class="col-3">
                                        <span class="kt-switch">
                                            <label>
                                            <input type="checkbox" value="1"  {{ isset($items) && $items->draft == 1 ? 'checked' :'' }} name="draft">
                                            <span></span>
                                            </label>
                                        </span>
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
                                            class="btn btn-danger">{{ isset($items) ? t('Update'):t('Create') }}</button>&nbsp;
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
    <script src="{{ asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js') }}" type="text/javascript"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    <script>
        $(document).ready(function() {
            $("form").keypress(function(e) {
                //Enter key
                if (e.which == 13) {
                    return false;
                }
            });


            $('#has_number').on('change', function() {
                if(this.checked){
                $('#number').show();
                } else{

                $('#number').hide();
                }
            });

        });

    </script>
    {!! $validator->selector('#form_information') !!}
@endsection
