<?php

namespace ThallesTeodoro\BaseAdmin\App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DashboardController extends Controller
{
    /**
     * Displays the admin dashboard view
     *
     * @return Illuminate\Http\Response
     */
    public function index()
    {
        return view('baseadmin::admin.pages.dashboard');
    }
}
