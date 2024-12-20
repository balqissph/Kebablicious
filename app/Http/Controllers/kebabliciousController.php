<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\product;

class kebabliciousController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kebablicious = product::paginate(5);

        return view('customerverifed.menucustomer', compact('kebablicious'));
    }
}
