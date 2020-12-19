<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Chat;
use App\Models\Item;
use App\Models\JoinUs;
use App\Models\Merchant;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\Speech;
use App\Models\SpeechComment;
use App\Models\Store;
use App\Models\User;
use App\Rules\EmailRule;
use App\Rules\IntroMobile;
use App\Rules\StartWith;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Proengsoft\JsValidation\Facades\JsValidatorFacade as JsValidator;
use Ramsey\Uuid\Uuid;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:General Settings', ['only' => ['settings', 'updateSettings']]);
    }

    public function home()
    {
        return view('manager.home');
    }

    public function settings()
    {

        $title = t('Show Settings');
//        $this->validationRules["email"] = 'required|email';
//        $this->validationRules["phone"] = ['required', 'min:13', 'max:13', new StartWith('+970'), new IntroMobile()];
//
        $validator = JsValidator::make($this->validationRules, $this->validationMessages);

        return view('manager.setting.general', compact('title', 'validator'));
    }

    public function updateSettings(Request $request)
    {
        $data = $request->except(['_token']);
        foreach ($data as $index => $item) {
            switch ($index) {
                case'logo':
                    $item = (request()->hasFile('logo')) ? $this->uploadImage($request->file('logo'), 'logos') : null;
                    if (isset($item)) saveSetting($index, $item);
                    break;

                case'bannerFile':
                    $item = (request()->hasFile('bannerFile')) ? $this->uploadImage($request->file('bannerFile'), 'bannerFile') : null;
                    if (isset($item)) saveSetting($index, $item);
                    break;

                case'adFile':
                    $item = (request()->hasFile('adFile')) ? $this->uploadImage($request->file('adFile'), 'adFile') : null;
                    if (isset($item)) saveSetting($index, $item);
                    break;

                case'occasions':
                    $item = (request()->hasFile('occasions')) ? $this->uploadImage($request->file('occasions'), 'occasions') : null;
                    if (isset($item)) saveSetting($index, $item);
                    break;

                case'about_us_image':
                    $item = (request()->hasFile('about_us_image')) ? $this->uploadImage($request->file('about_us_image'), 'about_us_image') : null;
                    if (isset($item)) saveSetting($index, $item);
                    break;
                default:
                    saveSetting($index, $item);
            }
        }
        Artisan::call('cache:clear');
        return redirect()->back()->with('message', t('Successfully Updated'))->with('m-class', 'success');
    }

    public function lang($local)
    {
        session(['lang' => $local]);
        if (Auth::guard('manager')->check()) {
            $user = Auth::guard('manager')->user();
            $user->update([
                'local' => $local,
            ]);
        }
        app()->setLocale($local);
        return back();
    }

    public function view_profile()
    {
        $title = t('Show Profile');
        return view('manager.setting.profile', compact('title'));
    }

    public function profile(Request $request)
    {
        $user = Auth::guard('manager')->user();
        $this->validationRules['password'] = 'nullable';
        $this->validationRules['email'] = ['required', 'unique:managers,email,' . $user->id, new EmailRule()];
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
        $user->update($data);
        return redirect()->back()->with('message', t('Successfully Updated'))->with('m-class', 'success');
    }
}
