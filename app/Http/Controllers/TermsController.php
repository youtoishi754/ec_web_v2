<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

class TermsController extends BaseController
{
    /**
     * 利用規約ページを表示
     */
    public function index()
    {
        return view('terms.index');
    }
}
