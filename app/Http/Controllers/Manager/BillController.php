<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Bill;
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
//        $this->validationRules["name"] = 'required|min:3|max:100';
    }

    public function index()
    {
        $title = t('Show Bills');
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
                    return draftName($item->draft);
                })
                ->addColumn('total_cost', function ($item) {
                    return $item->total_cost;
                })
                ->addColumn('actions', function ($category) {
                    return $category->action_buttons;
                })
                ->make();
        }
        return view('manager.bills.index', compact('title'));
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
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('manager.bills.edit', compact('title', 'validator', 'bill', 'users', 'items'));

    }


    public function store(Request $request)
    {
        if (isset($request->bill_id)) {
            $store = $this->_model->findOrFail($request->bill_id);
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

        $item_prices = $request->get('options', []);
        $total = 0;
        foreach ($item_prices as $key => $item_price) {
            $quantity = isset($item_price['quantity']) ? $item_price['quantity'] : 1;
            $total += (double)$item_price['cost_before'] * (double)$quantity;
        }
        $store->total_cost = $total;
        $store->save();

        /*
        *
        *old add ons
        */
        $old_option = $request->get('old_option', []);
        $newArr_prices = array_keys($old_option);
        $db_prices = optional(optional($store->items)->pluck('id'))->all();
//        dd($old_option,$newArr_prices,$db_prices);
        if (isset($db_prices)) {
            foreach ($db_prices as $index => $db_price) {
                if (!in_array($db_price, $newArr_prices)) BillItems::where('id', $db_price)->delete();
            }

        }
//        foreach ($old_option as $key => $item_price) {
//            $item_price["item_id"] = $store->id;
//            $item_price["draft"] = isset($item_price['draft']) ? 1 : 0;
//            $item_price["option_category_id"] = $option_category;
//            $price = ItemPrice::query()->find($key);
//            if ($price) $price->update($item_price);
//        }

        $item_prices = $request->get('options', []);
//        $total = 0;
        foreach ($item_prices as $key => $item_price) {
            $bill_item_store = new BillItems();
            $bill_item_store->bill_id = $store->id;
            $bill_item_store->item_id = $item_price['item_id'];
            $bill_item_store->cost_before = $item_price['cost_before'];
            $bill_item_store->cost_after = $item_price['cost_after'];
            $bill_item_store->quantity = isset($item_price['quantity']) ? $item_price['quantity'] : 1;
            $bill_item_store->total_cost = (double)$bill_item_store->cost_after * (double)$bill_item_store->quantity;
//            $total += $bill_item_store->total_cost;
            $bill_item_store->save();
        }
//        dd($this->_model->where('id', $store->id)->get());
//        $store->update([
//            'total_cost' => $total
//        ]);

        if (isset($request->bill_id)) {
            return redirect()->route('manager.bills.index')->with('m-class', 'success')->with('message', t('Successfully Updated'));
        } else {
            return redirect()->route('manager.bills.index')->with('m-class', 'success')->with('message', t('Successfully Created'));
        }
    }

    public function destroy($id)
    {
        $item = $this->_model->findOrFail($id);
        $item->delete();
        return redirect()->back()->with('m-class', 'success')->with('message', t('Successfully Deleted'));
    }


}
