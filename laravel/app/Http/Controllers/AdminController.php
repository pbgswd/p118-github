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
        //todo grab data from various models, counts, etc, put them on this page
        $data = [
            ['user' => Auth::user()],
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

        $csv = [];
        // $lines = file('../../files/Local118-CSV-Membership.csv', FILE_IGNORE_NEW_LINES);
        $lines = [];
        foreach ($lines as $key => $value) {
            $csv[$key] = str_getcsv($value);
        }

        foreach ($csv as $k => $c) {
            $data[$k]['name'] = $c[0].' '.$c[1];
            $data[$k]['email'] = $c[2];
            $data[$k]['membership_type'] = $c[3];
        }
        return view('admin.admin-blank');
    }

    public function development(): View
    {
        //todo method for page for development
        //todo file upload
        //todo image library insert image

        return view('admin.admin-development');
    }

    public function getphpinfo(User $user): Bool
    {
        return phpinfo();
    }
}
