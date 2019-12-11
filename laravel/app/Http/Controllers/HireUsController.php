<?php

namespace App\Http\Controllers;

use App\Models\HireUs;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HireUsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param HireUs $hireUs
     * @return Response
     */
    public function show(HireUs $hireUs)
    {
        $data = [];
        return view('hireus', ['data' => $data]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param HireUs $hireUs
     * @return Response
     */
    public function edit(HireUs $hireUs)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param HireUs $hireUs
     * @return Response
     */
    public function update(Request $request, HireUs $hireUs)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param HireUs $hireUs
     * @return Response
     */
    public function destroy(HireUs $hireUs)
    {
        //
    }
}
