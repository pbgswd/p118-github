<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    public function index(): View
    {
        $roles = Role::get();

        return view('admin.roles', ['data' => ['roles' => $roles]]);
    }
}
