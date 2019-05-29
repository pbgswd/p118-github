<?php

namespace App\Http\Controllers;


use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $roles = Role::get();

        return view('admin.roles', ['data' => array('roles' => $roles)]);
    }
}
