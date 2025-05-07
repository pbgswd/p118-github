<?php

namespace App\Http\Controllers;

use App\Models\Options;

/**
 * @property Controller $getFormOptions
 */
abstract class Controller
{

    protected function getFormOptions(array $options, $data = [])
    {
        foreach ($options as $option) {
            switch ($option) {
                case 'date':
                    $data['years'] = Options::years();
                    $data['months'] = Options::months();
                    $data['days'] = Options::days();
                    break;

                case 'countries':
                    $data['countries'] = Options::countries();
                    break;

                case 'statesprovs':
                    $data['statesprovs'] = Options::state_prov();
                    break;

                case 'access_levels':
                    $data['access_levels'] = Options::access_levels();
                    break;

                case 'membership_level':
                    $data['access_level'] = Options::membership_levels();
                    break;

                case 'committee_roles':
                    $data['committee_roles'] = Options::committee_roles();
                    break;

                case 'phone_label':
                    $data['phone_label'] = Options::phone_label();
                    break;
            }
        }

        return $data;
    }
}
