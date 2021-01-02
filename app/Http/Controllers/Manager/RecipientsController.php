<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Accountant;
use App\Models\BillFiles;
use App\Models\BillItems;
use App\Models\CDs;
use App\Models\Expense;
use App\Models\Payment;
use App\Models\Recipients;
use App\Models\User;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Yajra\DataTables\DataTables;
use function JmesPath\search;

class RecipientsController extends Controller
{
    private $_model;

    public function __construct(Recipients $recipients)
    {
//        dd('in progress');
        parent::__construct();
        $this->_model = $recipients;
        $this->middleware('permission:recipients', ['only' => ['index', 'create', 'edit']]);
//        $this->validationRules["name"] = 'required|min:3|max:100';
    }

    public function index()
    {
        $title = t('Show recipients');
        if (request()->ajax()) {
//            dd(checkRequestIsWorkingOrNot());
            $search = request()->get('title', false);
            $draft = request()->get('draft', false);
            $items = $this->_model->when($search, function ($query) use ($search) {
                $query->whereHas('accountant', function ($query) use ($search) {
                    $query->where('name', 'like', "%" . $search . '%');
                });
            })->latest();
            return DataTables::make($items)
                ->escapeColumns([])
                ->addColumn('created_at', function ($item) {
                    return Carbon::parse($item->created_at)->format(DATE_FORMAT);
                })
                ->addColumn('date', function ($item) {
                    return Carbon::parse($item->date)->format(DATE_FORMAT);
                })
                ->addColumn('accountant', function ($item) {
                    return optional($item->accountant)->name;
                })
                ->addColumn('note', function ($item) {
                    return $item->note;
                })
                ->addColumn('amount', function ($item) {
                    return $item->amount;
                })
                ->addColumn('actions', function ($item) {
                    return $item->action_buttons;
                })
                ->make();
        }
        return view('manager.recipients.index', compact('title'));
    }

    public function create()
    {
        $title = t('Add payments');
        $accountants = Accountant::get();

        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('manager.recipients.edit', compact('title', 'validator', 'accountants'));
    }

    public function edit($id)
    {
        $title = t('Edit recipients');
        $recipients = $this->_model->findOrFail($id);
        $accountants = Accountant::get();
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('manager.recipients.edit', compact('title', 'validator', 'recipients', 'accountants'));

    }

    public function store(Request $request)
    {
        if (isset($request->recipients_id)) {
            $store = $this->_model->findOrFail($request->recipients_id);
        } else {
            $store = new $this->_model();
        }

        $request->validate($this->validationRules);

        /*
         *
         */
        $accountant = Accountant::findOrFail($request->accountant);
        $total_payments = $accountant->payments()->sum('amount');
        $total_recipients = Recipients::where('accountant_id', $accountant->id)->sum('amount');
        if (!isset($request->recipients_id) && (double)$request->cost != $total_recipients) {
            $res = ($total_payments - ($total_recipients + (double)$request->cost));
//            dd($res, $total_payments, $total_recipients, $request->all());
            if ($res < 0) return redirect()->back()->with('m-class', 'error')->with('message', t('Not enough money'));
        } else {
//            dd((double)$request->cost , $total_recipients);
            if ((double)$request->cost != $total_recipients) {
            $res = ($total_payments - ($total_recipients + (double)$request->cost));
//                dd($res, $total_payments, $total_recipients, $request->all());
                if ($res < 0) return redirect()->back()->with('m-class', 'error')->with('message', t('Not enough money'));
            }
        }

        /*
         *
         */
        $store->accountant_id = $request->accountant;
        $store->amount = $request->cost;
        $store->note = $request->note;
        $store->date = $request->date;
        $store->draft = $request->get('draft', 0);
        $store->save();
        if (isset($request->expense_id)) {
            return redirect()->route('manager.recipients.index')->with('m-class', 'success')->with('message', t('Successfully Updated'));
        } else {
            return redirect()->route('manager.recipients.index')->with('m-class', 'success')->with('message', t('Successfully Created'));
        }
    }

    public function destroy($id)
    {
        $item = $this->_model->findOrFail($id);
        $item->delete();
        return redirect()->back()->with('m-class', 'success')->with('message', t('Successfully Deleted'));
    }
}
