<?php

namespace App\Http\Controllers\Office;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;

use App\Http\Controllers\Controller;

class SiteController extends Controller
{
    public function index()
    {
        View::share('sidebar',      'office.site.index');

        return view($this->view);
    }

    public function documents()
    {
        View::share('sidebar',      'office.site.documents');

        return view($this->view);
    }

}
