<?php

namespace App\Http\Controllers;

use App\Models\ModelList;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        //Land on the home page of admin. Could have data later.
        $data = [
            ['user' => Auth::user()]
        ];

        return view('admin.admin', ['data' => $data]);
    }

    /**
     * @return View
     */
    public function developer(): View
    {
        return view('admin.developer_admin');
    }

    /**
     * @param User $user
     * @return View
     */
    public function blank(User $user): View
    {
        $mod = new ModelList;
        $arr = ModelList::getModelList();

        $csv = array();
       // $lines = file('../../files/Local118-CSV-Membership.csv', FILE_IGNORE_NEW_LINES);
$lines =[];
        foreach ($lines as $key => $value)
        {
            $csv[$key] = str_getcsv($value);
        }

        foreach($csv as $k => $c)
        {
            $data[$k]['name'] = $c[0] . " " . $c[1];
            $data[$k]['email'] = $c[2];
            $data[$k]['membership_type'] = $c[3];
        }

//dd($data);


        return view('admin.admin-blank');
    }
}
