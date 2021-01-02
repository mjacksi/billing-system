<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\CDs;
use App\Models\Payment;
use App\Rules\EmailRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:General Settings', ['only' => ['settings', 'updateSettings']]);
    }

    public function home()
    {
        $total_payments = Payment::
        whereHas('bill', function ($query) {
            $query->where('user_id', auth()->guard('client')->id());
        })->orWhereHas('cds', function ($query) {
            $query->where('user_id', auth()->guard('client')->id());
        })->sum('amount');
        $bill_required_money = Bill::where('user_id', \auth()->guard('client')->id())->get()->map(function ($item) {
//            dd(abs($item->paid_amount - $item->total_cost));
            return [
                'sub' => abs($item->paid_amount - $item->total_cost)
            ];
        })->sum('sub');

        $cds_required_money = CDs::where('user_id', \auth()->guard('client')->id())->get()->map(function ($item) {
//            dd(abs($item->paid_amount - $item->total_cost));
            return [
                'sub' => abs($item->paid_amount - $item->amount)
            ];
        })->sum('sub');
        return view('client.home', compact('total_payments', 'bill_required_money', 'cds_required_money'));
    }


    public function view_profile()
    {
        $title = t('Show Profile');
        return view('client.setting.profile', compact('title'));
    }

    public function profile(Request $request)
    {
        $user = Auth::guard('client')->user();
        $this->validationRules['password'] = 'nullable';
        $this->validationRules['email'] = ['required', 'unique:users,email,' . $user->id, new EmailRule()];
        $request->validate($this->validationRules);

        $data = $request->all();
        if ($request->has(['password', 'password_confirmation']) && !empty($request->get('password'))) {
            $request->validate([
                'password' => 'min:6|confirmed'
            ]);
            $data['password'] = bcrypt($data['password']);
        } else {
            $data['password'] = $user->password;
        }
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        ]);
        return redirect()->back()->with('message', t('Successfully Updated'))->with('m-class', 'success');
    }
}
