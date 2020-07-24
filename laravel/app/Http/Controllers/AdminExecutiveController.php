<?php

namespace App\Http\Controllers;

use App\Http\Requests\Executive\AdminDestroyExecutive;
use App\Models\Executive;
use App\Models\ExecutiveMembership;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AdminExecutiveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = [];
        $data['executives'] = Executive::with('user')->get();

        return view('admin.executives_list', ['data' => $data]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     * @param  \App\Models\Executive  $executive
     * @param ExecutiveMembership $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(AdminDestroyExecutive $request)
    {
        foreach($request->id as $id)
        {
            ExecutiveMembership::destroy($id);
        }

        Session::flash('success', 'Member executive role deleted.');

        return redirect()->route('admin_executives');
    }
}
