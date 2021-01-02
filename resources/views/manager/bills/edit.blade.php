@extends('manager.layout.container')
@section('style')
    <link href="{{ asset('assets/vendors/general/bootstrap-tagsinput/dist/bootstrap-tagsinput.css') }}" rel="stylesheet"
          type="text/css"/>
@endsection


@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route_admin('bills.index') }}">{{t('Bills')}}</a>
        </li>
        <li class="breadcrumb-item">
            {{ isset($bill) ? t('Edit Bills') : t('Add Bills') }}
        </li>
    @endpush
    <div class="row">
        <div class="col-xl-12">
            <div class="kt-portlet">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">{{ isset($bill) ? t('Edit Bills') : t('Add Bills') }}</h3>
                    </div>
                </div>
                <form enctype="multipart/form-data" id="form_information" class="kt-form kt-form--label-right"
                      action="{{route_admin('bills.store') }}" method="post">
                    {{ csrf_field() }}
                    @if(isset($bill))
                        <input type="hidden" name="bill_id" value="{{$bill->id}}">
                    @endif


                    <div class="kt-portlet__body">
                        <div class="kt-section kt-section--first">
                            <div class="kt-section__body">
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Users') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <select class="form-control " name="user_id">
                                            <option value="" selected disabled>{{t('Select User')}}</option>
                                            @foreach($users as $user)
                                                <option
                                                    value="{{$user->id}}" {{isset($bill) && $bill->user_id == $user->id ? 'selected':''}}>{{$user->name}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Date') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="date" type="date"
                                               value="{{ isset($bill) ? $bill->date : old("date") }}">
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Expire Date') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input class="form-control" name="expire_date" type="date"
                                               value="{{ isset($bill) ? $bill->expire_date : old("expire_date") }}">
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Note') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <textarea name="note" id="note" cols="30" rows="10"
                                                  class="form-control">{{ isset($bill) ? $bill->note : old("note") }}</textarea>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-xl-3 col-lg-3 col-form-label">{{ t('Bill Files') }} </label>
                                    <div class="col-lg-9 col-xl-6">
                                        <input type="file" name="bill_files[]" multiple class="form-control">
                                       @if(isset($bill) && count($bill->files) > 0)

                                            @foreach($bill->files as $key=>$file)
                                                <a target="_blank" href="{{$file->file}}">{{t('Brows')}}</a>
                                                <br>
                                            @endforeach
                                           @endif
                                    </div>

                                </div>
{{--                                <div class="form-group row">--}}
{{--                                    <label class="col-3 col-form-label font-weight-bold">{{t('Draft')}}</label>--}}
{{--                                    <div class="col-3">--}}
{{--                                        <span class="kt-switch">--}}
{{--                                            <label>--}}
{{--                                            <input type="checkbox" value="1"--}}
{{--                                                   {{ isset($bill) && $bill->draft == 1 ? 'checked' :'' }} name="draft">--}}
{{--                                            <span></span>--}}
{{--                                            </label>--}}
{{--                                        </span>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

                                <hr>

                                <div class="col-md-2">
                                    <div class="form-group">
                                        <label>{{t('Add New')}}</label>
                                        <button type="button" class="btn btn-danger w-100 add_button"><i
                                                class="fa fa-plus-circle"></i> {{t('Add Option')}}</button>
                                    </div>
                                </div>
                                <br>
                                <br>


                                <div class="row_container">
                                    @isset($bill)
                                        @foreach($bill->items as $item)
                                            <div class="row">
                                                <div class="col-md-3">
                                                    <div class="form-group">
                                                        <label>{{ t('Item') }}</label>

                                                        <select onchange="getCost(this)" data-row="{{$item->id}}"
                                                                name="old_option[{{$item->id}}][item_id]"
                                                                class="form-control">
                                                            <option value=''>{{t('Select Item')}}</option>
                                                            @foreach($items as $key2=>$item2)
                                                                <option value="{{$item2->id}}"
                                                                        {{$item2->is($item->item)? 'selected' : ''}}
                                                                        data-cost-before='{{$item2->cost_before}}'
                                                                        data-cost-after='{{$item2->cost_after}}'>  {{$item2->name}}</option>

                                                                {{--                                                            <option value="{{$item->id}}">  {{$item->name}}</option>--}}
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>{{ t('Cost Before') }}</label>
                                                        <input name="old_option[{{$item->id}}][cost_before]"
                                                               type="number" step="0.9" class="form-control"
                                                               value="{{$item/*->pivot*/->cost_before}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>{{ t('Cost After') }}</label>
                                                        <input name="old_option[{{$item->id}}][cost_after]"
                                                               type="number" step="0.9" class="form-control"
                                                               value="{{$item/*->pivot*/->cost_after}}">
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <div class="form-group">
                                                        <label>{{ t('Quantity') }}</label>
                                                        <input name="old_option[{{$item->id}}][quantity]"
                                                               type="number" step="1" class="form-control"
                                                               value="{{$item/*->pivot*/->quantity}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <div class="form-group">
                                                        <label>{{ t('Delete') }} </label>
                                                        <div class="w-100">
                                                            <button
                                                                class="btn btn-danger btn-icon removed_button"
                                                                data-id="{{$item->id}}"><i
                                                                    class="fa fa-times"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endisset
                                </div>


                            </div>
                        </div>
                    </div>
                    <div class="kt-portlet__foot">
                        <div class="kt-form__actions">
                            <div class="row">
                                <div class="col-lg-12 text-right">
                                    <button type="submit"
                                            class="btn btn-danger">{{ isset($bill) ? t('Update'):t('Create') }}</button>&nbsp;
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

        /*
        new things
         */


        var x = 1; //Initial field counter is 1
        var y = 1; //Initial field counter is 1

        var maxField = 5; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.row_container'); //Input field wrapper
        //Once add button is clicked
        $(addButton).click(function () {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                y++; //Increment field counter

                $(wrapper).append(
                    "<div class=\"row\">\n" +
                    "<div class=\"col-md-3\">\n" +
                    "<div class=\"form-group\">\n" +
                    "<label>{{ t('Item') }}</label>" +
                    "<select onchange=\"getCost(this)\"  name=\"options[" + y + "][item_id]\" data-row=\"" + x + "\" class=\"form-control\">\n" +
                    "@foreach($items as $key=>$item)"
                    + "@if($loop->first)"
                    + "<option value=''>{{t('Select Item')}}</option><option value=\"{{$item->id}}\" data-cost-before='{{$item->cost_before}}'  data-cost-after='{{$item->cost_after}}'>  {{$item->name}}</option>\n" +
                    "@else\n"
                    + "<option value=\"{{$item->id}}\" data-cost-before='{{$item->cost_before}}'  data-cost-after='{{$item->cost_after}}'>  {{$item->name}}</option>\n" +
                    "@endif\n" +
                    "@endforeach\n" +
                    "</select></div></div>" +
                    "<div class=\"col-md-2\">" +
                    "<div class=\"form-group\">" +
                    "<label>{{ t('Price') }}</label>" +
                    "<input  type=\"number\" " +
                    "name=\"options[" + x + "][cost_before]\"\n" +
                    "id=\"row" + x + "\n" +
                    "                  step=\"0.9\" class=\"form-control\"\n" +
                    "                   value=\"\">\n" +
                    "</div>" +
                    "</div>" +


                    "<div class=\"col-md-2\">" +
                    "<div class=\"form-group\">" +
                    "<label>{{ t('Price After') }}</label>" +
                    "<input name=\"options[" + x + "][cost_after]\"\n" +
                    "                   type=\"number\" step=\"0.9\" class=\"form-control\"\n" +
                    "                   value=\"\">\n" +
                    "</div>" +
                    "</div>" +

                    "<div class=\"col-md-2\">" +
                    "<div class=\"form-group\">" +
                    "<label>{{ t('Quantity') }}</label>" +
                    "<input name=\"options[" + x + "][quantity]\"\n" +
                    "                   type=\"number\" step=\"1.0\" class=\"form-control\"\n" +
                    "                   value=\"1\">\n" +
                    "</div>" +
                    "</div>" +
                    "<div class=\"col-md-1\">\n" +
                    "<div class=\"form-group\">\n" +
                    "<label>{{ t('Delete') }} </label>\n" +
                    "<div class=\"w-100\">\n" +
                    "<button class=\"btn btn-danger btn-icon remove_button\"><i class=\"fa fa-times\"></i></button>\n" +
                    "</div>\n" +
                    "</div>\n" +
                    "</div>\n" +

                    "</div>"
                ); //Add field html
            }
        });

        function getCost(item) {
            // var cost_before = item.getAttribute("data-cost-before");
            // var cost_after = item.getAttribute("data-cost-after");
            var cost_before = item.options[item.selectedIndex].getAttribute('data-cost-before')
            var cost_after = item.options[item.selectedIndex].getAttribute('data-cost-after');
            var row = item.getAttribute('data-row');
            console.log(cost_before, cost_after, row);
            console.log('item.nextElementSibling');
            console.log(item.parentElement.parentElement.nextElementSibling);
            var item_cost_before = item.parentElement.parentElement.nextElementSibling;
            item_cost_before.childNodes[0].childNodes[1].value = cost_before;
            var item_cost_after = item.parentElement.parentElement.nextElementSibling.nextElementSibling;
            item_cost_after.childNodes[0].childNodes[1].value = cost_after;
            console.log('item');
            console.log(item);
            $("#old_option[" + row + "][cost_before]").val(56465)

            // $("#old_option["+row+"][cost_before]").val(function(index,cost_before))

            console.log(document.querySelector("#row2"))
            // document.getElementById("row2").value = 5465;
            // console.log($("#row2").val(66546546))
            console.log($("#row" + row))
        }

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function (e) {
            e.preventDefault();
            $(this).parent('div').parent('div').parent('div').parent('div').remove(); //Remove field html
            x--;
        });
        // Once remove button is clicked
        $(wrapper).on('click', '.removed_button', function (e) {
            e.preventDefault();
            let ele = $(this);
            ele.attr('disabled', true)
            ele.parent('div').parent('div').parent('div').parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });


    </script>
    {!! $validator->selector('#form_information') !!}
@endsection
