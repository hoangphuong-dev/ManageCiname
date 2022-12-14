<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\ShowTimeService;
use Illuminate\Http\Request;

class ShowTimeController extends Controller
{
    protected $showTimeService;

    public function __construct(ShowTimeService $showTimeService)
    {
        $this->showTimeService = $showTimeService;
    }

    public function index(Request $request)
    {
        dd($request->all());
        return $this->showTimeService->list($request);
    }

    public function listShowTimeByRoom($roomId, Request $request)
    {
        return $this->showTimeService->listShowTimeByRoom($roomId, $request);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd(222);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
