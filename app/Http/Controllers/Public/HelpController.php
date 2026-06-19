<?php

namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;

class HelpController extends Controller
{
    public function faq()
    {
        return view('public.help.faq');
    }
}
