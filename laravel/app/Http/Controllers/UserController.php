<?php

namespace App\Http\Controllers;

use App\Http\Requests\User\DestroyUser;
use App\Http\Requests\User\StoreUser;
use App\Http\Requests\User\UpdateUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;


/**
 * Class UserController
 * @package App\Http\Controllers
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $users = User::sortable()->paginate(10);

        return view('admin.listusers', ['data'=>array('users'=>$users )]);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $user = new User;

        return view('admin.user', ['data' => ['user' => $user, 'action' => 'Create']]);
    }

    /**
     * @param StoreUser $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUser $request)
    {
        $user = new User($request->input('user'));

        $user->save();

        Session::flash('success', "You have saved a new member");

        return redirect()->route('user_edit', [$user->id]);
    }

    /**
     * @param User $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(User $user)
    {
        $currentUser = Auth::user();

        $data = [
            'user' => $user,
            'action' => 'Edit',
            'currentUserPermissions' => $currentUser->permissions,
            'image' => 'image.jpg',
            'share_image' => '',
            'phone' => '',
            'share_phone' => '',
            'share_email' => '',
            'street' => '',
            'city' => '',
            'postal_code' => '',
            'country' => '',
            'dues_status' => '',
            'membership_number' => '',
            'membership_status' => '',
            'membership_date' => '',
            'admin_notes' => '',
        ];

        return view('admin.user', ['data'=> $data]);
    }

    /**
     * @param UpdateUser $request
     * @param User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUser $request, User $user)
    {
        $user->fill($request['user']);
        $user->save();
        Session::flash('success', "You have edited a member profile");

        return redirect()->route('user_edit', [$user->id]);
    }

    /**
     * @param DestroyUser $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(DestroyUser $request)
    {
       User::destroy($request->id);
       Session::flash('success', Str::plural('Member', count($request->id)) . ' deleted.');

       return redirect()->route('users_list');
    }
}
