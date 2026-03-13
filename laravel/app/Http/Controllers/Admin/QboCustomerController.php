<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QboToken;
use QuickBooksOnline\API\DataService\DataService;
use App\Services\QboService;
class QboCustomerController extends Controller
{
    public function view(QboService $qbo)
    {
        $email = request('email');
        $customer = null;

        if ($email) {
            $results = $qbo->query("SELECT * FROM Customer WHERE PrimaryEmailAddr = '" . addslashes($email) . "'");
            $customer = $results ? $results[0] : null;
        }

        return view('admin.qbo.customer', compact('customer', 'email'));
    }

    public function index(QboService $qbo)
    {

//        $customers = $qbo->query("SELECT * FROM Customer ORDER BY DisplayName");
 //$customers = $qbo->query("SELECT * FROM Customer WHERE FullyQualifiedName LIKE '%MEMBERS%'");
//dd($customers);

	//   $customers = $qbo->query("SELECT * FROM Customer where email='Sporting_goods@intuit.com'");
        //$customer = $qbo->query("SELECT * FROM Customer WHERE PrimaryEmailAddr = '{$email}'");
       // $customer[0] = $qbo->findCustomerByEmail($email);
       // $customer = $customer ? $customer[0] : null;

        return view('admin.qbo.customers', [
            'customers' => $customers ?: [],
        ]);
    }
}
