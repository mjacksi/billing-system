<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillFiles;
use App\Models\BillItems;
use App\Models\User;
use App\Models\Item;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Yajra\DataTables\DataTables;

class BillController extends Controller
{
    private $_model;

    public function __construct(Bill $bill)
    {
        parent::__construct();
        $this->_model = $bill;
        $this->middleware('permission:bills', ['only' => ['index', 'create', 'edit']]);
        $this->validationRules["user_id"] = 'required|exists:users,id';
        $this->validationRules["options.*.item_id"] = 'required';
        $this->validationRules["options.*.cost_before"] = 'required';
        $this->validationRules["options.*.cost_after"] = 'required';
        $this->validationRules["options.*.quantity"] = 'required';
        $this->validationRules["date"] = 'required';
        $this->validationRules["expire_date"] = 'required';

    }

    public function index()
    {
        $this->validationRules = [];
        $this->validationMessages = [];
        $this->validationRules["amount"] = 'required|numeric';
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);


        $title = t('Show Bills');
        if (request()->ajax()) {
            $search = request()->get('title', false);
            $draft = request()->get('draft', false);
            $date_start = request()->get('from', false);
            $date_end = request()->get('to', false);


            $items = $this->_model->when($search, function ($query) use ($search) {
                $query->where('uuid', 'like', '%' . $search . '%');
            })
                ->when($date_start, function ($query) use ($date_start) {
                    $query->whereDate('created_at', '>=', Carbon::parse($date_start));
                })
                ->when($date_end, function ($query) use ($date_end) {
                    $query->whereDate('created_at', '<=', Carbon::parse($date_end));
                })
                ->when($draft != null, function ($query) use ($draft) {
                $query->where('draft', $draft);
            })->latest();
            return DataTables::make($items)
                ->escapeColumns([])
                ->addColumn('expire_date', function ($item) {
                    return Carbon::parse($item->expire_date)->format(DATE_FORMAT);
                })

                ->addColumn('uuid', function ($item) {
                    return $item->uuid;
                })
                ->addColumn('client', function ($item) {
                    return optional($item->client)->name;
                })
                ->addColumn('status_name', function ($item) {
                    return $item->status_name;
                })
                ->addColumn('total_cost', function ($item) {
                    return $item->total_cost;
                })
                ->addColumn('paid_amount', function ($item) {
                    return $item->paid_amount;
                })
                ->addColumn('remaining_amount', function ($item) {
                    return abs($item->paid_amount - $item->total_cost);
                })
                ->addColumn('actions', function ($category) {
                    return $category->action_buttons;
                })
                ->make();
        }
        return view('manager.bills.index', compact('title', 'validator'));
    }


    public function addPayment(Request $request, $id)
    {
        $this->validationRules = [];
        $this->validationMessages = [];
        $this->validationRules["amount"] = 'required|numeric';
        $request->validate($this->validationRules);
        $bill = $this->_model->findOrFail($id);
        $sub = (double)$bill->paid_amount - $bill->total_cost;
        $sub = abs($sub);

        if ($sub == 0) return redirect()->back()->with('m-class', 'error')->with('message', t('Can not add Payment'));
        if ((double)$request->amount > $sub) return redirect()->back()->with('m-class', 'error')->with('message', t('Can not add Payment you have to add  or less',[
            'money' => $sub
        ]));
        $bill->payments()->create([
            'amount' => $request->amount,
            'note' => $request->note,
            'user_id' => $bill->user_id,
            'manager_id' => auth()->guard('manager')->id(),
            'type' => \App\Models\Payment::BILL,
        ]);
        return redirect()->back()->with('message', t('Successfully Updated'))->with('m-class', 'success');
    }

    public function create()
    {
        $title = t('Add Bills');
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        $users = User::get();
        $items = Item::get();
        return view('manager.bills.edit', compact('title', 'validator', 'users', 'items'));
    }

    public function edit($id)
    {
        $title = t('Edit Bills');
        $bill = $this->_model->findOrFail($id);
        $users = User::get();
        $items = Item::get();
        $this->validationRules["old_option.*.item_id"] = 'required';
        $this->validationRules["old_option.*.cost_before"] = 'required';
        $this->validationRules["old_option.*.cost_after"] = 'required';
        $this->validationRules["old_option.*.quantity"] = 'required';

        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('manager.bills.edit', compact('title', 'validator', 'bill', 'users', 'items'));

    }

    public function store(Request $request)
    {
        if (isset($request->bill_id)) {
            $store = $this->_model->findOrFail($request->bill_id);
            $this->validationRules["old_option.*.item_id"] = 'required';
            $this->validationRules["old_option.*.cost_before"] = 'required';
            $this->validationRules["old_option.*.cost_after"] = 'required';
            $this->validationRules["old_option.*.quantity"] = 'required';
        } else {
            $store = new $this->_model();
        }
        $request->validate($this->validationRules);
//        dd(checkRequestIsWorkingOrNot());
        $store->user_id = $request->user_id;
        $store->date = $request->date;
        $store->expire_date = $request->expire_date;
        $store->note = $request->note;
        $store->draft = $request->get('draft', 0);
        $getLastId = ($this->_model->count() > 0) ? $this->_model->get()->last()->id : '1';
        $store->uuid = date('Y') . date('m') . $getLastId;


        /*
        *
        *old add ons
        */
//        $old_option = $request->get('old_option', []);
//        $newArr_prices = array_keys($old_option);
//        $db_prices = optional(optional($store->items)->pluck('id'))->all();
////        dd($old_option,$newArr_prices,$db_prices);
//        if (isset($db_prices)) {
//            foreach ($db_prices as $index => $db_price) {
//                if (!in_array($db_price, $newArr_prices)) {
//                    $db_price = BillItems::where('id', $db_price)->first();
//                    $store -= $db_price->cost_after;
//                    $db_price->delete();
//                }
//            }
//
//        }

        $store->items()->delete();
        $item_prices = $request->get('options', []);
        $old_option = $request->get('old_option', []);
        if (is_array($old_option) && sizeof($old_option) > 0) {
            $total = 0;//this is the last total cost before we're edit this
            foreach ($old_option as $key => $item_price) {
                $quantity = isset($item_price['quantity']) ? $item_price['quantity'] : 1;
                $total += (double)$item_price['cost_after'] * (double)$quantity;
            }
            $store->total_cost = $total;
        }
        if (is_array($item_prices) && sizeof($item_prices) > 0) {
            $total = $store->total_cost;//this is the last total cost before we're edit this
            foreach ($item_prices as $key => $item_price) {
                $quantity = isset($item_price['quantity']) ? $item_price['quantity'] : 1;
                $total += (double)$item_price['cost_after'] * (double)$quantity;
            }
//            dd($total);
            $store->total_cost = $total;
        }
        $store->save();


        $old_option = $request->get('old_option', []);

        foreach ($old_option as $key => $item_price) {
            $bill_item_store = new BillItems();
            $bill_item_store->bill_id = $store->id;
            $bill_item_store->item_id = $item_price['item_id'];
            $bill_item_store->cost_before = $item_price['cost_before'];
            $bill_item_store->cost_after = $item_price['cost_after'];
            $bill_item_store->quantity = isset($item_price['quantity']) ? $item_price['quantity'] : 1;
            $bill_item_store->total_cost = (double)$bill_item_store->cost_after * (double)$bill_item_store->quantity;
            $bill_item_store->save();
        }


        $item_prices = $request->get('options', []);
        foreach ($item_prices as $key => $item_price) {
            $bill_item_store = new BillItems();
            $bill_item_store->bill_id = $store->id;
            $bill_item_store->item_id = $item_price['item_id'];
            $bill_item_store->cost_before = $item_price['cost_before'];
            $bill_item_store->cost_after = $item_price['cost_after'];
            $bill_item_store->quantity = isset($item_price['quantity']) ? $item_price['quantity'] : 1;
            $bill_item_store->total_cost = (double)$bill_item_store->cost_after * (double)$bill_item_store->quantity;
            $bill_item_store->save();
        }

//        upload files

        if (is_array($request->bill_files) && sizeof($request->bill_files) > 0) {
            $store->files()->delete();
            foreach ($request->bill_files as $key => $file) {
                $bill_file_store = new BillFiles();
                $bill_file_store->bill_id = $store->id;
                if ($file->isValid()) {
                    $bill_file_store->file = $this->uploadImage($file, 'bill_files');
                }
                $bill_file_store->save();
            }
        }
        if (isset($request->bill_id)) {
            return redirect()->route('manager.bills.index')->with('m-class', 'success')->with('message', t('Successfully Updated'));
        } else {
            return redirect()->route('manager.bills.index')->with('m-class', 'success')->with('message', t('Successfully Created'));
        }
    }


    public function show($id)
    {
        $title = t('Show Bill') . ' #' . $id;
        $bill = $this->_model->findOrFail($id);
        return view('manager.bills.show', compact('title', 'bill'));
    }

    public function destroy($id)
    {
        $item = $this->_model->findOrFail($id);
        $item->payments()->delete();
        $item->delete();
        return redirect()->back()->with('m-class', 'success')->with('message', t('Successfully Deleted'));
    }


}
