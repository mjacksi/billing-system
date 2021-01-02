@extends('accountant.layout.container')
@section('style')
    <link href="{{ asset('assets/css/demo6/pages/general/invoices/invoice-1.'.direction('.').'css') }}" rel="stylesheet"
          type="text/css"/>
@endsection
@section('content')
    @push('breadcrumb')
        <li class="breadcrumb-item">
            <a href="{{ route('accountant.bills.index') }}">{{ t('Bills') }}</a>
        </li>
        <li class="breadcrumb-item">
            {{ t('Bill Review') }}
        </li>
    @endpush

    <!-- begin:: Content -->
    <div class="kt-portlet">
        <div class="kt-portlet__body kt-portlet__body--fit">
            <div class="kt-invoice-1">
                <div class="kt-invoice__wrapper">
                    <div class="kt-invoice__head" style="background: linear-gradient(to right,#db1515,#ec5252);">
                        <div class="kt-invoice__container kt-invoice__container--centered">
                            <div class="kt-invoice__logo mb-3" style="padding-top: 2rem;">
                                <a href="{{route('accountant.bills.show', $bill->id)}}">
                                    <h1 class="mb-4">{{ t('Bill Details') }}</h1>
                                    {{--                                    <span class="text-white" style="font-weight: 500">{{ t('User :').' '.optional($bill->client)->name }}</span>--}}
                                    <br/>
                                </a>
                            </div>

                            <div class="kt-invoice__items"
                                 style="border-top: 1.5px solid #ffffff;padding: 2rem 0 2rem 0;">
                                <div class="kt-invoice__item">
                                    <span class="kt-invoice__subtitle">{{ t('Bill') .' '. t('Date') }} :</span>
                                    <span class="kt-invoice__text text-white" style="font-weight: 500"
                                          dir="ltr">{{ \Carbon\Carbon::parse($bill->created_at)->format(DATE_FORMAT) }}</span>
                                </div>
                                <div class="kt-invoice__item">
                                    <span class="kt-invoice__subtitle">{{ t('ORDER NO') }}</span>
                                    <span class="kt-invoice__text text-white" style="font-weight: 500 "
                                          dir="ltr"> {{ $bill->uuid }}</span>
                                </div>
                                <div class="kt-invoice__item text-white" style="font-weight: 500">
                                    <span class="kt-invoice__subtitle">{{ t('User :') }}</span>
                                    <span class="kt-invoice__text text-white" style="font-weight: 500">
                                        <a class="text-white" href="javascript:;">{{ $bill->client->name  }}</a>
                                            <br>
                                            <b dir="ltr">{{ $bill->client->phone }}</b>
                                            <br/>
                                        </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="kt-invoice__body kt-invoice__body--centered">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{ t('Items') }}</th>
                                    {{--                                    <th class="text-center">{{ t('Cost Before') }}</th>--}}
                                    <th class="text-center">{{ t('Cost After') }}</th>
                                    <th class="text-center">{{ t('Quantity') }}</th>
                                    <th class="text-center">{{ t('amount') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                @forelse($bill->items as $item)
                                    <tr>
                                        <td>{{ $item->item->name }} </td>
                                        {{--                                        <td class="text-center">{{ $item/*->pivot*/->cost_before }}</td>--}}
                                        <td class="text-center">{{ $item/*->pivot*/->cost_after }}</td>
                                        <td class="text-center">{{ $item/*->pivot*/->quantity }}</td>
                                        <td class="text-center">{{ $item/*->pivot*/->total_cost }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td class="text-center" colspan="4">{{t('No Items')}}</td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>

                        </div>
                        @if($bill->note)
                            <hr/>
                            <div class="kt-invoice__content mt-4">
                                <h5 class="kt-invoice__price">{{t('Note')}}:</h5>
                                <p>{{$bill->note}}</p>
                            </div>
                        @endif

                    </div>
                    <div class="kt-invoice__footer">
                        <div class="kt-invoice__container kt-invoice__container--centered">
                            <div class="kt-invoice__content">
                                <span>{{ t('Bill details') }}</span>
                                <span><span>{{ t('Bill Amount') }}:</span><span class="kt-invoice__price" dir="ltr">{{ $bill->total_cost }}</span></span>
                                <span><span>{{ t('Bill Payments') }}:</span><span class="kt-invoice__price"
                                                                                  dir="ltr">{{ $bill->paid_amount }}</span></span>

                                <span><span>{{ t('Remaining Amount') }}:</span><span class="kt-invoice__price"
                                                                                     dir="ltr">{{ abs($bill->paid_amount - $bill->total_cost) }}</span></span>
                            </div>
                            <div class="kt-invoice__content">
                                <span>{{ t('Status') }}</span>
                                <span class="kt-invoice__price">{{ $bill->status_name }}</span>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="kt-invoice__actions row">
        <div class="kt-invoice__container  col-md-6">
            <button type="button" class="btn btn-danger btn-bold"
                    onclick="window.print();">{{ t('Print Order') }}</button>
        </div>
    </div>


    <!-- end:: Content -->
@endsection
@section('script')

@endsection

