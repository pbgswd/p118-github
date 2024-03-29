<?php

namespace App\Models;

use App\Constants\AccessLevelConstants;
use function array_combine;
use function range;

/**
 * @property Options $access_levels
 * @property Options $membership_levels
 * @property Options $committee_roles
 * @property Options $committee_executive_roles
 * @property Options $executive
 * @property Options $phone_label
 * @property Options $state_prov
 * @property Options $years
 * @property Options $months
 * @property Options $days
 * @property Options $fetchOptionTypes
 */
class Options
{
    /**
     * @return array
     */
    public static function thumb_values(): array
    {
        $arr = [
            'height' => 75,
            'width' => 75,
            'tn_str' => 'tn_75x75_',
        ];

        return $arr;
    }

    /**
     * @return array
     */
    public static function memoriam_thumb_values(): array
    {
        $arr = [
            'height' => 125,
            'width' => 125,
            'tn_str' => 'tn_125x125_',
        ];

        return $arr;
    }

    /**
     * @return array
     */
    public static function feature_thumb_values(): array
    {
        $arr = [
            'height' => 250,
            'width' => 250,
            'tn_str' => 'tn_250x250_',
        ];

        return $arr;
    }

    /**
     * @return array
     */
    public static function venue_org_thumb_values(): array
    {
        $arr = [
            'height' => 200,
            'width' => 200,
            'tn_str' => 'tn_200x200_',
        ];

        return $arr;
    }

    /**
     * @return array
     */
    public static function member_thumb_values(): array
    {
        $arr = [
            'height' => 200,
            'width' => 200,
            'tn_str' => 'tn_200x200_',
        ];

        return $arr;
    }

    /**
     * @return string[]
     */
    public static function address_update_contacts(): array
    {
        $contacts = ['dispatch@iatse118.com', 'payroll@iatse118.com',
            'healthandwelfare@iatse118.com', 'returningofficer@iatse118.com', ];

        return $contacts;
    }

    /**
     * @return string[]
     */
    public static function testing_address_update_contacts(): array
    {
        $contacts = ['pbgswd@gmail.com', 'financialsecretary@iatse118.com'];

        return $contacts;
    }

    /**
     * @return array
     */
    public static function access_levels(): array
    {
        $levels = AccessLevelConstants::getConstants();

        return array_combine($levels, $levels);
    }

    /**
     * @return mixed
     */
    public static function membership_levels(): array
    {
        $membership = ['Member', 'Office'];
    // 'Inactive', 'Suspended', 'Retired', 'Non-member', 'Client', 'Permittee'];

        return array_combine($membership, $membership);
    }

    public static function message_frequency_preference_options(): array
    {
        $frequency = ['now' => "Send when published (default option).",
                        'daily' => "Daily compilation, All messages for that day in one email.",
                        'weekly' => "All messages for that week in one email. ",
                        'unsubscribe' => "Dont email me any messages, I will check the Messages archive on the website instead."
        ];
        return  $frequency;
    }

    public static function model_subscription_options():array
    {
        /**
         * 'Employment',  uses id
         * 'Memoriam',  uses slug, should be more unique
         * 'Bylaw',  uses id
         * 'Policy',  uses 24
         * 'Meeting', uses id
         * 'Venue',  uses slug
         * 'Organization', uses slug
         * 'Agreement',  uses id
         * 'Message',  uses id, trying to use slug...
         */

        $array = [
            ['model' => 'Employment', 'name' => 'Job Postings', 'key' => 'id', 'description' => 'Latest job postings'],
            ['model' => 'Bylaw', 'name' => 'Constitution and Bylaws', 'key' => 'id', 'description' => 'Updates to Constitution and Bylaws in Local 118'],
            ['model' => 'Policy', 'name' => 'Policies', 'key' => 'id', 'description' => 'Local 118 Policies'],
            ['model' => 'Meeting', 'name' => 'Meetings and Minutes', 'key' => 'id', 'description' => 'Information about meetings'],
            ['model' => 'Agreement', 'name' => 'Agreements', 'key' => 'id', 'description' => 'Agreements that Local 118 works under'],
            ['model' => 'Message', 'name' => 'Messages', 'key' => 'id', 'description' => 'Published strictly as a message'],
            ['model' => 'Memoriam', 'name' => 'In Memoriam', 'key' => 'slug', 'description' => 'Notification of the passing of members'],
            ['model' => 'Venue', 'name' => 'Venues', 'key' => 'slug', 'description' => 'Venues where we work'],
            ['model' => 'Organization', 'name' => 'Organizations', 'key' => 'slug', 'description' => 'Organizations that we work for'],
            ['model' => 'Feature', 'name' => 'Features', 'key' => 'slug', 'description' => 'Feature content'],
        ];

        return $array;
    }

    /**
     * @return mixed
     */
    public static function committee_roles(): array
    {
        $membership = ['Chair', 'Co-Chair', 'Alternate Chair', 'Secretary', 'Member', 'Interim Member', 'Ex-officio', 'Past-Member'];

        return array_combine($membership, $membership);
    }

    /**
     * @return mixed
     */
    public static function committee_executive_roles(): array
    {
        $committee_executive_roles = ['Chair', 'Co-Chair', 'Secretary', 'Alternate Chair'];

        return array_combine($committee_executive_roles, $committee_executive_roles);
    }

    /**
     * @return mixed
     */
    public static function phone_label(): array
    {
        $phone_labels = ['cel', 'home', 'work', 'other'];

        return array_combine($phone_labels, $phone_labels);
    }

    /**
     * @return array
     */
    public static function state_prov(): array
    {
        $provinces = [];
        $provinces['AB'] = 'Alberta';
        $provinces['BC'] = 'British Columbia';
        $provinces['MB'] = 'Manitoba';
        $provinces['NB'] = 'New Brunswick';
        $provinces['NF'] = 'Newfoundland';
        $provinces['NS'] = 'Nova Scotia';
        $provinces['NT'] = 'Northwest Territories';
        $provinces['NU'] = 'Nunavut';
        $provinces['ON'] = 'Ontario';
        $provinces['PE'] = 'Prince Edward Island';
        $provinces['QC'] = 'Quebec';
        $provinces['SK'] = 'Saskatchewan';
        $provinces['YT'] = 'Yukon';

        return ['Provinces' => $provinces, null => 'Other (See next field)'];
    }

    /**
     * @return array
     */
    public static function years(): array
    {
        $currentYear = date('Y');
        $years = range(($currentYear - 2), ($currentYear + 10));

        return array_combine($years, $years);
    }

    /**
     * @return array
     */
    public static function months(): array
    {
        $months = [];
        $months[1] = 'January';
        $months[2] = 'February';
        $months[3] = 'March';
        $months[4] = 'April';
        $months[5] = 'May';
        $months[6] = 'June';
        $months[7] = 'July';
        $months[8] = 'August';
        $months[9] = 'September';
        $months[10] = 'October';
        $months[11] = 'November';
        $months[12] = 'December';

        return $months;
    }

    /**
     * @return array
     */
    public static function days(): array
    {
        $days = range(1, 31);

        return array_combine($days, $days);
    }

    /**
     * @param $class
     * @return array
     */
    public static function fetchOptionTypes($class): array
    {
        $sorted = $class::orderBy('sort_order')->get();
        $data = [];
        $sorted->map(function ($item) use (&$data) {
            $data[$item->code] = $item->display_text;
        });

        return $data;
    }
}
