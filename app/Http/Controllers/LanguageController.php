<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    /**
     * Switch the application language.
     *
     * @param  string  $lang
     * @return \Illuminate\Http\RedirectResponse
     */
    public function switchLang($lang)
    {
        if (in_array($lang, ['en', 'al'])) {
            Session::put('applocale', $lang);
            App::setLocale($lang);

            if (auth()->check()){
                auth()->user()->update(['language' => $lang]);
            }
        }
        return redirect()->back();
    }
}
