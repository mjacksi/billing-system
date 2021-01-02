@extends('manager.layout.container')
@section('style')
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
@endsection

@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            {{t('payments')}}
        </li>
    @endpush

    <div class="row">
        <div class="col-md-12">
            <div class="kt-portlet kt-portlet--height-fluid">
                <div class="kt-portlet__head">
                    <div class="kt-portlet__head-label">
                        <h3 class="kt-portlet__head-title">
                            {{t('payments')}}
                        </h3>
                    </div>
{{--                    <div class="kt-portlet__head-toolbar">--}}
{{--                        <div class="kt-portlet__head-wrapper">--}}
{{--                            <div class="kt-portlet__head-actions">--}}
{{--                                <a href="{{ route('manager.payments.create') }}" class="btn btn-danger btn-elevate btn-icon-sm">--}}
{{--                                    <i class="la la-plus"></i>--}}
{{--                                    {{t('Add payments')}}--}}
{{--                                </a>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
                </div>
                <div class="kt-portlet__body">
                    <form class="kt-form kt-form--fit kt-margin-b-20">
                        <div class="row kt-margin-b-20">
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                <label>{{ t('Title') }}:</label>
                                <input type="text" name="title" id="title" class="form-control kt-input" placeholder="{{t('Title')}}">
                            </div>
                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                <label>{{ t('Type') }}:</label>
                                <select class="form-control" name="draft" id="draft">
                                    <option selected value="">{{t('Select Type')}}</option>
                                    <option value="{{\App\Models\Payment::BILL}}" >{{t('Bill')}}</option>
                                    <option value="{{\App\Models\Payment::CDS}}" >{{t('Cds')}}</option>
                                    <option value="{{\App\Models\Payment::CDS2}}" >{{t('Cds2')}}</option>
                                </select>
                            </div>

                            <div class="col-lg-2 kt-margin-b-10-tablet-and-mobile">
                                <label>{{ t('Action') }}:</label>
                                <br />
                                <button type="button" class="btn btn-danger btn-elevate btn-icon-sm" id="kt_search">
                                    <i class="la la-search"></i>
                                    {{t('Search')}}
                                </button>
                                &nbsp;&nbsp
                            </div>
                        </div>
                    </form>
                    <table class="table text-center" id="users-table">
                        <thead>
                        <th>{{t('User')}}</th>
                        <th>{{t('Amount')}}</th>
                        <th>{{t('Type')}}</th>
                        <th>{{t('Uuid')}}</th>
                        <th>{{t('Created At')}}</th>
                        <th>{{t('Actions')}}</th>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{w('Confirm Delete')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    </button>
                </div>
                <form method="post" action="" id="delete_form">
                    <input type="hidden" name="_method" value="delete">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>{{t('Are You Sure To Delete The Selected Row')}}</p>
                        <p>{{t('Deleting The Selected Row Results In Deleting All Records Related To It')}}.</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{w('Cancel')}}</button>
                        <button type="submit" class="btn btn-warning">{{w('Delete')}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
@section('script')
    <!-- DataTables -->
    <script src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-datetime-picker/js/bootstrap-datetimepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/vendors/general/bootstrap-timepicker/js/bootstrap-timepicker.min.js') }}" type="text/javascript"></script>
    <!-- Bootstrap JavaScript -->
    <script>
        $(document).ready(function(){
            $(document).on('click','.deleteRecord',(function(){
                var id = $(this).data("id");
                var url = '{{ route("manager.payments.destroy", ":id") }}';
                url = url.replace(':id', id );
                $('#delete_form').attr('action',url);
            }));

            $(function() {

                $('#users-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ordering:false,
                    searching: false,
                    dom: 'lBfrtip',
                    buttons: [
                        'excel', 'print'
                    ],
                    @if(app()->getLocale() == 'ar')
                    language: {
                        url: "http://cdn.datatables.net/plug-ins/1.10.21/i18n/Arabic.json"
                    },
                    @endif
                    ajax: {
                        url : '{{ route('manager.payments.index') }}',
                        data: function (d) {
                            d.title = $("#title").val();
                            d.draft = $("#draft").val();
                        }
                    },
                    columns: [
                        {data: 'user', name: 'user'},
                        {data: 'amount', name: 'amount'},
                        {data: 'type', name: 'type'},
                        {data: 'uuid', name: 'uuid'},
                        {data: 'created_at', name: 'created_at'},
                        {data: 'actions', name: 'actions'}
                    ],
                });
            });
            $('#kt_search').click(function(){
                $('#users-table').DataTable().draw(true);
            });
        });
    </script>
@endsection
