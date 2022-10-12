<?php

namespace App\Http\Controllers;

use App\Models\FieldPrice;
use Illuminate\Http\Request;

class FieldPriceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return FieldPrice::all();
    }
}