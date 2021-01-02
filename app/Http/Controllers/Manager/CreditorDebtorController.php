<?php

namespace App\Http\Controllers\Manager;

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
//        $this->validationRules["title"] = 'required|min:3|max:100';
        $this->validationRules["cost"] = 'required|numeric';
        $this->validationRules["note"] = 'nullable|min:3|max:100';
        $this->validationRules["client"] = 'required|exists:users,id';
//        $this->validationRules["type"] = 'required|in:' . CDs::CREDITOR . ',' . CDs::DEBTOR;
    }

    public function index()
    {
        $this->validationRules = [];
        $this->validationMessages = [];
        $this->validationRules["amount"] = 'required|numeric';
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        $title = t('Show cds');
        if (request()->ajax()) {
//            dd(checkRequestIsWorkingOrNot());
            $search = request()->get('title', false);
            $draft = request()->get('draft', false);
            $items = $this->_model->where('type',CDs::CREDITOR)->when($search, function ($query) use ($search) {
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
                ->addColumn('remaining_amount', function ($item) {
                    return abs($item->paid_amount - $item->amount);
                })
                ->addColumn('status', function ($item) {
                    return $item->status;
                })
                ->addColumn('status_name', function ($item) {
                    return $item->status_name;
                })
                ->addColumn('actions', function ($item) {
                    return $item->action_buttons;
                })
                ->make();
        }
        return view('manager.cds.index', compact('title', 'validator'));
    }

    public function addPayment(Request $request, $id)
    {
        $this->validationRules = [];
        $this->validationMessages = [];
        $this->validationRules["amount"] = 'required|numeric';
        $request->validate($this->validationRules);
        $cdn = $this->_model->findOrFail($id);
        $sub = (double)$cdn->paid_amount - $cdn->amount;
        $sub = abs($sub);

        if ( $sub == 0) return redirect()->back()->with('m-class', 'error')->with('message', t('Can not add Payment'));
        if ((double)$request->amount > $sub) return redirect()->back()->with('m-class', 'error')->with('message', t('Can not add Payment you have to add ' . $sub . ' or less'));

        $cdn->payments()->create([
            'amount' => $request->amount,
            'user_id' => $cdn->user_id,
            'note' => $request->note,
            'manager_id' => auth()->guard('manager')->id(),
            'type' => \App\Models\Payment::CDS,
        ]);


        return redirect()->back()->with('message', t('Successfully Updated'))->with('m-class', 'success');
    }

    public function create()
    {
        $title = t('Add cds');
        $users = User::get();

        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('manager.cds.edit', compact('title', 'validator', 'users'));
    }

    public function edit($id)
    {
        $title = t('Edit cds');
        $cds = $this->_model->findOrFail($id);
        $users = User::get();
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('manager.cds.edit', compact('title', 'validator', 'cds', 'users'));

    }


    public function store(Request $request)
    {
        if (isset($request->cds_id)) {
            $store = $this->_model->findOrFail($request->cds_id);
        } else {
            $store = new $this->_model();
        }
        $request->validate($this->validationRules);
        $store->user_id = $request->client;
        $store->amount = $request->cost;
        $store->note = $request->note;
        $store->type = CDs::CREDITOR;
        $store->draft = $request->get('draft', 0);
        $getLastId = ($this->_model->count() > 0) ? $this->_model->get()->last()->id : '1';
        $store->uuid = date('Y') . date('m') . $getLastId;
        $store->save();
        if (isset($request->expense_id)) {
            return redirect()->route('manager.cds.index')->with('m-class', 'success')->with('message', t('Successfully Updated'));
        } else {
            return redirect()->route('manager.cds.index')->with('m-class', 'success')->with('message', t('Successfully Created'));
        }
    }

    public function destroy($id)
    {
        $item = $this->_model->findOrFail($id);
        $item->delete();
        return redirect()->back()->with('m-class', 'success')->with('message', t('Successfully Deleted'));
    }


}
