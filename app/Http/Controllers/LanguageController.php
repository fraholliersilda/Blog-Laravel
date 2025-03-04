<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

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
        try {
            if (!in_array($lang, ['en', 'al'])) {
                throw new \InvalidArgumentException('Invalid language selection');
            }

            Session::put('applocale', $lang);
            App::setLocale($lang);

            if (auth()->check()) {
                auth()->user()->update(['language' => $lang]);
            }

            return redirect()->back()->with('success', 'Language updated successfully.');
        } catch (\Throwable $th) {
            Log::error('Language switch error: ' . $th->getMessage());

            return redirect()->back()->with('error', 'Failed to change language.');
        }
    }
}
