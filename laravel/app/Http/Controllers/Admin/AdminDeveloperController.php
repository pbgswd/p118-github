<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AdminDeveloperController extends Controller
{
    protected $activityLog;

    public function __construct() {}

    public function index(): View
    {
        return view('admin.developer.developer_admin');
    }

    public function blank(User $user): View
    {
        return view('admin.developer.admin-blank');
    }

    public function insert(): View
    {
        // todo method for page for development
        // todo file upload
        // todo image library insert image

        $data['textarea'] = fake()->paragraph();

        return view('admin.attachments.list_attachments_endless', ['data' => $data]);
    }

    public function drag(): View
    {
        // todo method for page for development
        // todo file upload
        // todo image library insert image

        $data['textarea'] = fake()->paragraph();

        return view('admin.developer.drag', ['data' => $data]);
    }

    public function getphpinfo(User $user): bool
    {
        return phpinfo();
    }

    public function datepicker(User $user): View
    {
        return view('admin.developer.datepicker');
    }
}
