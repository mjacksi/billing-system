<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Accountant;
use App\Models\Recipients;
use App\Rules\EmailRule;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Yajra\DataTables\DataTables;

class AccountantController extends Controller
{
    private $_model;

    public function __construct(Accountant $accountant)
    {
        parent::__construct();
        $this->_model = $accountant;
        $this->middleware('permission:accountants', ['only' => ['index', 'create', 'edit']]);
        $this->validationRules["name"] = 'required|min:3|max:100';
        $this->validationRules["email"] = ['required', 'unique:accountants,email,{$id},id,deleted_at,NULL', new EmailRule()];
    }

    public function index()
    {
        $title = t('Show Accountants');
        if (request()->ajax()) {
            $search = request()->get('title', false);
            $draft = request()->get('draft', false);
            $items = $this->_model->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->when($draft != null, function ($query) use ($draft) {
                $query->where('draft', $draft);
            })->latest();
            return DataTables::make($items)
                ->escapeColumns([])
                ->addColumn('created_at', function ($category) {
                    return Carbon::parse($category->created_at)->toDateTimeString();
                })
                ->addColumn('status_name', function ($item) {
                    return draftName($item->draft);
                })
                ->addColumn('recipients', function ($item) {
                    return $item->total_recipients;
                })
                ->addColumn('actions', function ($category) {
                    return $category->action_buttons;
                })
                ->make();
        }
        return view('manager.accountants.index', compact('title'));
    }

    public function create()
    {
        $title = t('Add Accountants');
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('manager.accountants.edit', compact('title', 'validator'));
    }


    public function edit($id)
    {
        $title = t('Edit Accountants');
        $accountants = $this->_model->findOrFail($id);
        $this->validationRules["email"] = ['required', 'unique:accountants,email,' . $accountants->id . ',id,deleted_at,NULL', new EmailRule()];

        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('manager.accountants.edit', compact('title', 'validator', 'accountants'));

    }


    public function store(Request $request)
    {
        if (isset($request->accountants_id)) {
            $store = $this->_model->findOrFail($request->accountants_id);
            $this->validationRules["email"] = ['required', 'unique:accountants,email,' . $store->id . ',id,deleted_at,NULL', new EmailRule()];
        } else {
            $store = new $this->_model();
        }
        $request->validate($this->validationRules);
//        dd(checkRequestIsWorkingOrNot());
        $store->name = $request->name;
        $store->email = $request->email;
        $store->phone = $request->phone;
        if (isset($request->accountants_id)) {
            $store->password = !is_null($request->get('password')) ? bcrypt($request->get('password', 123456)) : $store->password;
        } else {
            $store->password = Hash::make($request->password);
        }
        $store->draft = $request->get('draft', 0);
        $store->save();
        $permissions = [
            'General Settings',
            'items',
            'recipients',
            'accountants',
            'users',
            'bills',
            'expenses',
            'cds',//creditor_debtor
            'cds2',//creditor_debtor
            'payments',
        ];
        if (!isset($request->accountants_id)) {
            foreach ($permissions as $permission) {
//                \Spatie\Permission\Models\Permission::create(['name' => $permission, 'guard_name' => 'accountant']);
                $store->givePermissionTo($permission);
            }
        }


        if (isset($request->accountants_id)) {
            return redirect()->route('manager.accountants.index')->with('m-class', 'success')->with('message', t('Successfully Updated'));
        } else {
            return redirect()->route('manager.accountants.index')->with('m-class', 'success')->with('message', t('Successfully Created'));
        }
    }

    public function destroy($id)
    {
        $item = $this->_model->findOrFail($id);
        $item->delete();
        return redirect()->back()->with('m-class', 'success')->with('message', t('Successfully Deleted'));
    }


}
