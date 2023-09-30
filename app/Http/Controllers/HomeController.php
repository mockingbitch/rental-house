<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function adminDashboard()
    {
        return view('dashboard');
    }
  
    /**
     * @Route get("/", name="top")
     *
     * @return Response
     */
    public function index(): Response
    {
        return Inertia::render('Top');
    }
}
