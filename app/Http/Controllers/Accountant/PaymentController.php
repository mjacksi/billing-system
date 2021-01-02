<?php

namespace App\Http\Controllers\Accountant;

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

class PaymentController extends Controller
{
    private $_model;

    public function __construct(Payment $payment)
    {
//        dd('in progress');
        parent::__construct();
        $this->_model = $payment;
        $this->middleware('permission:payments', ['only' => ['index', 'create', 'edit']]);
//        $this->validationRules["name"] = 'required|min:3|max:100';
    }

    public function index()
    {
        $title = t('Show payments');
        if (request()->ajax()) {
//            dd(checkRequestIsWorkingOrNot());
            $search = request()->get('title', false);
            $draft = request()->get('draft', false);
            $items = $this->_model->when($search, function ($query) use ($search) {
                $query->whereHas('bill', function ($query) use ($search) {
                    $query->where('uuid', 'like', '%' . $search . '%')->orWhereHas('client',function ($query) use ($search){
                        $query->where('name', 'like', '%' . $search . '%');
                    });
                })->orWhereHas('cds', function ($query) use ($search) {
                    $query->where('uuid', 'like', '%' . $search . '%')->orWhereHas('user',function ($query) use ($search){
                        $query->where('name', 'like', '%' . $search . '%');
                    });//->where('user_id',auth()->guard('client')->id());
                });

            })->when($draft, function ($query) use ($draft) {
                $query->where('type', $draft);
            })->latest();
            return DataTables::make($items)
                ->escapeColumns([])
                ->addColumn('created_at', function ($item) {
                    return Carbon::parse($item->created_at)->format(DATE_FORMAT);
                })
                ->addColumn('user', function ($item) {
//                    dd($item->getOriginal('type'));
                    if ($item->type == Payment::BILL) {
                        return optional(optional($item->bill)->client)->name;
                    }

                    if ($item->type == Payment::CDS) {
                        return optional(optional($item->cds)->user)->name;
                    }
                })
                ->addColumn('amount', function ($item) {
                    return $item->amount;
                })
                ->addColumn('type', function ($item) {
                    return $item->type_name;
                })
                ->addColumn('uuid', function ($item) {
//                    dd($item->getOriginal('type'));
                    if ($item->type == Payment::BILL) {
                        return optional($item->bill)->uuid;
                    }

                    if ($item->type == Payment::CDS) {
                        return optional($item->cds)->uuid;
                    }
                })
                ->addColumn('actions', function ($item) {
                    return $item->action_buttons;
                })
                ->make();
        }
        return view('accountant.payments.index', compact('title'));
    }

    public function create()
    {
        $title = t('Add payments');
        $users = User::get();

        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('accountant.payments.edit', compact('title', 'validator', 'users'));
    }

    public function edit($id)
    {
        $title = t('Edit payments');
        $payments = $this->_model->findOrFail($id);
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('accountant.payments.edit', compact('title', 'validator', 'payments'));

    }


    public function store(Request $request)
    {
        if (isset($request->payments_id)) {
            $store = $this->_model->findOrFail($request->payments_id);
        } else {
            $store = new $this->_model();
        }
        $request->validate($this->validationRules);
        $store->amount = $request->amount;
        $store->draft = $request->get('draft', 0);
        $store->save();
        if (isset($request->expense_id)) {
            return redirect()->route('accountant.payments.index')->with('m-class', 'success')->with('message', t('Successfully Updated'));
        } else {
            return redirect()->route('accountant.payments.index')->with('m-class', 'success')->with('message', t('Successfully Created'));
        }
    }

    public function destroy($id)
    {
        $item = $this->_model->findOrFail($id);
        $item->delete();
        return redirect()->back()->with('m-class', 'success')->with('message', t('Successfully Deleted'));
    }


}
