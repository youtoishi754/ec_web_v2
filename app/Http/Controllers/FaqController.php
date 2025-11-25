<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class FaqController extends BaseController
{
    /**
     * FAQページを表示
     */
    public function index()
    {
        return view('faq.index');
    }
}
