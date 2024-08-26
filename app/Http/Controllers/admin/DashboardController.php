<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function indexAdmin() {
        return view('admin.dashboard');
    }

    public function indexRecruiter() {
        return view('recruiter.dashboard');
    }

    
}
