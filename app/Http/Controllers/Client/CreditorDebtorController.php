<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\BillFiles;
use App\Models\BillItems;
use App\Models\CDs;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\User;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Yajra\DataTables\DataTables;

class CreditorDebtorController extends Controller
{
    private $_model;

    public function __construct(CDs $CDs)
    {
        parent::__construct();
        $this->_model = $CDs;
        $this->middleware('permission:cds', ['only' => ['index', 'create', 'edit']]);
    }

    public function index()
    {
        $title = t('Show cds');
        if (request()->ajax()) {
//            dd(checkRequestIsWorkingOrNot());
            $search = request()->get('title', false);
            $draft = request()->get('draft', false);
            $items = $this->_model
                ->where('user_id', auth()->guard('client')->id())
                ->when($search, function ($query) use ($search) {
                    $query->where('uuid', 'like', '%' . $search . '%');
                })->when($draft != null, function ($query) use ($draft) {
                    $query->where('draft', $draft);
                })->latest();
            return DataTables::make($items)
                ->escapeColumns([])
                ->addColumn('created_at', function ($item) {
                    return Carbon::parse($item->created_at)->format(DATE_FORMAT);
                })
                ->addColumn('uuid', function ($item) {
                    return $item->uuid;
                })
                ->addColumn('user', function ($item) {
                    return optional($item->user)->name;
                })
                ->addColumn('type_name', function ($item) {
                    return $item->type_name;
                })
                ->addColumn('amount', function ($item) {
                    return $item->amount;
                })
                ->addColumn('paid_amount', function ($item) {
                    return $item->paid_amount;
                })
                ->addColumn('status', function ($item) {
                    return $item->status;
                })
                ->addColumn('status_name', function ($item) {
                    return draftName($item->draft);
                })
                ->addColumn('actions', function ($item) {
                    return $item->action_buttons;
                })
                ->make();
        }
        return view('client.cds.index', compact('title'));
    }
}
