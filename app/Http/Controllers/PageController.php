<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia;

class PageController extends Controller
{
    public function index()
    {
        # code...
        $data = [
            'name'=>"John Doe",
            'age'=>36
        ];
        return Inertia::render("Contacts/Contact",compact('data'));
    }
}
