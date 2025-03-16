<?php

namespace App\Http\Controllers;

use App\Enums\User\GenderUser;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Support\Facades\Session;
class ConfigController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function changeLang(Request $request, Application $app)
    {
        $lang = $request->input('lang');

        if (in_array($lang, ['vi', 'en'])) {
            Session::put('locale', $lang);
            App::setLocale($lang);

            return redirect()->back();
        }

        return redirect()->back()
            ->with(
                ['message' => Lang::get('messages.invalid-language'), 'status' => 'success']
            );
    }
}
