<?php

namespace App\Http\Controllers;

use App\Models\studentdetails;
use App\Models\studentmarks;
use Illuminate\Http\Request;

class Maincontroller extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
		return view('upload');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\studentdetails  $studentdetails
     * @return \Illuminate\Http\Response
     */
    public function show(studentdetails $studentdetails)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\studentdetails  $studentdetails
     * @return \Illuminate\Http\Response
     */
    public function edit(studentdetails $studentdetails)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\studentdetails  $studentdetails
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, studentdetails $studentdetails)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\studentdetails  $studentdetails
     * @return \Illuminate\Http\Response
     */
    public function destroy(studentdetails $studentdetails)
    {
        //
    }
}
