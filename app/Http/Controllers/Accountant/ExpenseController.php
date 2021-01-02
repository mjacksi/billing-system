<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Expense;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Yajra\DataTables\DataTables;

class ExpenseController extends Controller
{
    private $_model;

    public function __construct(Expense $expense)
    {
        parent::__construct();
        $this->_model = $expense;
        $this->middleware('permission:expenses', ['only' => ['index', 'create', 'edit']]);
        $this->validationRules["title"] = 'required|min:3|max:100';
        $this->validationRules["details"] = 'nullable|min:3|max:100';
        $this->validationRules["cost"] = 'required|numeric';
    }

    public function index()
    {
        $title = t('Show Expenses');
        if (request()->ajax()) {
            $search = request()->get('title', false);
            $draft = request()->get('draft', false);
            $items = $this->_model->when($search, function ($query) use ($search) {
                $query->where('uuid', 'like', '%' . $search . '%');
            })->when($draft != null, function ($query) use ($draft) {
                $query->where('draft', $draft);
            })->latest();
            return DataTables::make($items)
                ->escapeColumns([])
                ->addColumn('created_at', function ($item) {
                    return Carbon::parse($item->created_at)->format(DATE_FORMAT);
                })
                ->addColumn('status_name', function ($item) {
                    return draftName($item->draft);
                })
                ->addColumn('actions', function ($category) {
                    return $category->action_buttons;
                })
                ->make();
        }
        return view('accountant.expenses.index', compact('title'));
    }

    public function create()
    {
        $title = t('Add Expenses');
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('accountant.expenses.edit', compact('title', 'validator'));
    }


    public function edit($id)
    {
        $title = t('Edit Expenses');
        $expense = $this->_model->findOrFail($id);
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('accountant.expenses.edit', compact('title', 'validator', 'expense'));

    }


    public function store(Request $request)
    {
        if (isset($request->expense_id)) {
            $store = $this->_model->findOrFail($request->expense_id);
        } else {
            $store = new $this->_model();
        }
        $request->validate($this->validationRules);
//        dd(checkRequestIsWorkingOrNot());
        $store->title = $request->title;
        $store->details = $request->details;
        $store->cost = $request->cost;
        $store->draft = $request->get('draft', 0);
        $store->save();
        if (isset($request->expense_id)) {
            return redirect()->route('accountant.expenses.index')->with('m-class', 'success')->with('message', t('Successfully Updated'));
        } else {
            return redirect()->route('accountant.expenses.index')->with('m-class', 'success')->with('message', t('Successfully Created'));
        }
    }

    public function destroy($id)
    {
        $item = $this->_model->findOrFail($id);
        $item->delete();
        return redirect()->back()->with('m-class', 'success')->with('message', t('Successfully Deleted'));
    }


}
