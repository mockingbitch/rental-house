<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function userInformation()
    {
        return Inertia::render('Auth/AccountInformation/Index');
    }
}
