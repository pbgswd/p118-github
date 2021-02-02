<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $roles = Role::get();

        return view('admin.roles', ['data' => ['roles' => $roles]]);
    }
}
