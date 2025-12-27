<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change($lang)
    {
        if (in_array($lang, ['fa', 'en'])) {
            Session::put('locale', $lang);
            App::setLocale($lang);
        }

        return redirect()->back();
    }
}
