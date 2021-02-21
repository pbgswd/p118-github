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
     * @return string[]
     */
    public static function address_update_contacts(): array
    {
        $contacts = ['dispatch@iatse118.com', 'payroll@iatse118.com',
            'healthandwelfare@iatse118.com', 'returningofficer@iatse118.com'];

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
        $membership = ['Member', 'Office']; // 'Suspended', 'Retired', 'Non-member', 'Client', 'Permittee'];

        return array_combine($membership, $membership);
    }

    /**
     * @return mixed
     */
    public static function committee_roles(): array
    {
        $membership = ['Chair', 'Co-Chair', 'Secretary', 'Member', 'Past-Member'];

        return array_combine($membership, $membership);
    }

    /**
     * @return mixed
     */
    public static function committee_executive_roles(): array
    {
        $committee_executive_roles = ['Chair', 'Co-Chair', 'Secretary'];

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
