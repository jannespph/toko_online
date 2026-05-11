<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;    // <--- TAMBAHKAN INI
use Inertia\Response;   // <--- TAMBAHKAN INI

class DashboardController extends Controller
{
    public function index(): Response 
    { 
        return Inertia::render('Admin/Dashboard'); 
    }
}