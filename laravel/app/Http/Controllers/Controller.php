<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Models\Options;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected function getFormOptions(array $options, $data = array())
    {
        foreach ($options as $option)
        {
            switch ($option)
            {
                case 'date':
                    $data['years']  = Options::years();
                    $data['months'] = Options::months();
                    $data['days']   = Options::days();
                    break;

                case 'countries':
                    $data['countries'] = Options::countries();
                    break;

                case 'statesprovs':
                    $data['statesprovs'] = Options::state_prov();
                    break;
/*
                case 'pay_methods':
                    $data['pay_methods'] = Options::fetchOptionTypes('App\Models\PayMethodType');
                    break;

                case 'newsletter_formats':
                    $data['newsletter_formats'] = Options::fetchOptionTypes('App\Models\NewsletterFormatType');
                    break;

                case 'newsletter_file_types_descriptions':
                    $types = Options::fetchOptionTypes('App\Models\NewsletterFormatType');

                    $cleanTypes = [];

                    foreach($types as $k => $v)
                    {
                        $cleanTypes[$k] = [
                            'type' => $k,
                            'file_type' => strtolower($k) . '_file',
                            'description' => $v
                        ];
                    }

                    $data['newsletter_file_types_descriptions'] = $cleanTypes;

                    break;

                case 'newsletter_file_types':
                    $types = Options::fetchOptionTypes('App\Models\NewsletterFormatType');
                    $types = Options::fetchOptionTypes('App\Models\NewsletterFormatType');

                    $data['newsletter_file_types'] =  array_map(
                        function($val) {
                            return strtolower($val.'_file');
                        },
                        array_keys($types)
                    );
                    break;

                case 'newsletter_issue_types':
                    $data['newsletter_issue_types'] = Options::fetchOptionTypes('App\Models\NewsletterIssueType');
                    break;

                case 'subscription_types':
                    $data['subscription_types'] = Options::fetchOptionTypes('App\Models\SubscriptionType');
                    break;

                case 'newsletter_statuses':
                    $data['newsletter_statuses'] = Options::fetchOptionTypes('App\Models\NewsletterStatus');
                    break;*/
            }
        }
        return $data;
    }

}
