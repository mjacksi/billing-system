<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use Carbon\Carbon;
use Yajra\DataTables\DataTables;

class BillController extends Controller
{
    private $_model;
    public function __construct(Bill $bill)
    {
        parent::__construct();
        $this->_model = $bill;
        $this->middleware('permission:bills', ['only' => ['index', 'create', 'edit']]);
    }
    public function index()
    {
        $title = t('Show Bills');
        if (request()->ajax()) {
            $search = request()->get('title', false);
            $draft = request()->get('draft', false);
            $items = $this->_model
                ->where('user_id',auth()->guard('client')->id())
                ->when($search, function ($query) use ($search) {
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
        return view('client.bills.index', compact('title'));
    }
    public function show($id)
    {
        $title = t('Show Bill') . ' #' . $id;
        $bill = $this->_model->where('user_id',auth()->guard('client')->id())->findOrFail($id);
        return view('client.bills.show', compact('title', 'bill'));
    }
}
