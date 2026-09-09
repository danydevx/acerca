<?php

namespace App\Http\Controllers;

use Inertia\Inertia;

class BulmaPlaygroundController extends Controller
{
    public function index()
    {
        return Inertia::render('Public/BulmaPlayground');
    }
}
