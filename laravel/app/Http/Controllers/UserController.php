<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Http\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::sortable()->paginate(60);

        return view('admin.listusers', ['data'=>array('users'=>$users )]);
    }

    public function create()
    {
        $user = new User;

        return view('admin.user', ['data' => ['user' => $user, 'action' => 'Create']]);
    }

    public function store()
    {}

    public function edit(User $user)
    {
        $data = ['user'=>$user, 'action'=>'Edit'];

        return view('admin.user', ['data'=> $data]);
    }

    public function update()
    {}

    public function destroy()
    {}
}
