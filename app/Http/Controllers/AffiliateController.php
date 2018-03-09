<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Affiliate;

class AffiliateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $affiliates = Affiliate::all();
        return view('affiliates.index', compact("affiliates"));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Affiliate $affiliate)
    {
        return view('affiliates.show', compact("affiliate"));
    }
}
