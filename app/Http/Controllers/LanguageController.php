<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LanguageController extends Controller
{
    public function change(Request $request)
    {
        $lang = $request->lang;

        if (!in_array($lang, ['en', 'th'])) {
            abort(400);
        }

        Session::put('locale', $lang);

        return redirect()->back();
    }
}
