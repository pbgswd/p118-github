<?php

namespace App\Http\Controllers;


use Illuminate\Http\Response;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {

        $roles = Role::get();

        return view('admin.roles', ['data' => ['roles' => $roles]]);
    }
}
