<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Response;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //Land on the home page of admin. Could have data later.
        $data = [];
        return view('admin.admin', ['data' => $data]);
    }


    /**
     * @return Application|Factory|View
     */
    public function blank(User $user)
    {

        $user = User::permission('coffee')->with('roles')->get()->all();

        if($user[0]->can('coffee')) {

            //todo assign permission to user through role

            //$user[0]->givePermissionTo(['coffee','tea']);

            echo 'has role';
            dd($user[0]->roles[0]->name);
        }
        else
        {
            echo "not that role";
        }
  exit();
//

       // dd(Role::all()->pluck('name'));
        // a page for doing css/js/html experiments
        return view('admin.admin-blank');
    }

}
