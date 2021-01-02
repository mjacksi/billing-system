<?php

namespace App\Http\Controllers\Accountant;

use App\Http\Controllers\Controller;
use App\Models\Item;
use App\Models\LatestNews;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Yajra\DataTables\DataTables;

class ItemController extends Controller
{
    private $_model;

    public function __construct(Item $item)
    {
        parent::__construct();
        $this->_model = $item;
        $this->middleware('permission:items', ['only' => ['index', 'create', 'edit']]);
        $this->validationRules["name"] = 'required|min:3|max:100';
    }

    public function index()
    {
        $title = t('Show Items');
        if (request()->ajax()) {
            $search = request()->get('title', false);
            $draft = request()->get('draft', false);
            $items = $this->_model->when($search, function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%');
            })->when($draft != null, function ($query) use ($draft) {
                $query->where('draft', $draft);
            });
            return DataTables::make($items)
                ->escapeColumns([])
                ->addColumn('created_at', function ($category) {
                    return Carbon::parse($category->created_at)->toDateTimeString();
                })
                ->addColumn('status_name', function ($item) {
                    return $item->status_name;
                })
                ->addColumn('actions', function ($category) {
                    return $category->action_buttons;
                })
                ->make();
        }
        return view('accountant.items.index', compact('title'));
    }

    public function create()
    {
        $title = t('Add Latest News');
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('accountant.items.edit', compact('title', 'validator'));
    }


    public function edit($id)
    {
        $title = t('Edit Latest News');
        $items = $this->_model->findOrFail($id);
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);
        return view('accountant.items.edit', compact('title', 'validator', 'items'));

    }


    public function store(Request $request)
    {
        if (isset($request->items_id)) {
            $store = $this->_model->findOrFail($request->items_id);
        } else {
            $store = new $this->_model();
        }
        $request->validate($this->validationRules);
//        dd(checkRequestIsWorkingOrNot());
        $store->name = $request->name;
        $store->unit = $request->unit;
        $store->cost_before = $request->cost_before;
        $store->cost_after = $request->cost_after;
        if ($request->has_number) {
            $store->number = $request->number;
        }
        $store->hasNumber = $request->get('has_number', 0);
        $store->draft = $request->get('draft', 0);
        $store->save();

        if (isset($request->items_id)) {
            return redirect()->route('accountant.items.index')->with('m-class', 'success')->with('message', t('Successfully Updated'));
        } else {
            return redirect()->route('accountant.items.index')->with('m-class', 'success')->with('message', t('Successfully Created'));
        }
    }

    public function destroy($id)
    {
        $item = $this->_model->findOrFail($id);
        $item->delete();
        return redirect()->back()->with('m-class', 'success')->with('message', t('Successfully Deleted'));
    }


}
