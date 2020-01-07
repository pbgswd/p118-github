<?php

namespace App\Models;

/**
 * @property Options $access_levels
 * @property Options $membership_levels
 * @property Options $committee_roles
 * @property Options $committee_executive_roles
 * @property Options $executive
 * @property Options $phone_label
 * @property Options $state_prov
 * @property Options $countries
 * @property Options $years
 * @property Options $months
 * @property Options $days
 * @property Options $fetchOptionTypes
 */

class Options
{
    public static function access_levels()
    {
        $access = ['public', 'members'];
        return array_combine($access, $access);
    }

    public static function membership_levels()
    {
        $membership = ['Non-member', 'Permittee', 'Member', 'Office', 'Executive', 'Suspended', 'Retired'];
        return array_combine($membership, $membership);
    }

    public static function executive()
    {
        $executive = ['President', 'Vice-President', 'Business Agent', 'Member at Large', 'Secretary', 'Health and Welfare'];
        return array_combine($executive, $executive);
    }

    public static function committee_roles()
    {
        $membership = ['Chair', 'Co-Chair', 'Secretary', 'Member', 'Past-Member'];
        return array_combine($membership, $membership);
    }

    public static function committee_executive_roles()
    {
        $committee_executive_roles = ['Chair', 'Co-Chair', 'Secretary'];
        return array_combine($committee_executive_roles, $committee_executive_roles);
    }

    public static function phone_label()
    {
        $phone_labels = ['cel', 'home', 'work', 'other'];
        return array_combine($phone_labels, $phone_labels);
    }

    public static function state_prov()
    {
        $provinces = array();
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

        $states = array();
        $states['AL'] = 'Alabama';
        $states['AK'] = 'Alaska';
        $states['AZ'] = 'Arizona';
        $states['AR'] = 'Arkansas';
        $states['CA'] = 'California';
        $states['CO'] = 'Colorado';
        $states['CT'] = 'Connecticut';
        $states['DE'] = 'Delaware';
        $states['FL'] = 'Florida';
        $states['GA'] = 'Georgia';
        $states['HI'] = 'Hawaii';
        $states['ID'] = 'Idaho';
        $states['IL'] = 'Illinois';
        $states['IN'] = 'Indiana';
        $states['IA'] = 'Iowa';
        $states['KS'] = 'Kansas';
        $states['KY'] = 'Kentucky';
        $states['LA'] = 'Louisiana';
        $states['ME'] = 'Maine';
        $states['MD'] = 'Maryland';
        $states['MA'] = 'Massachusetts';
        $states['MI'] = 'Michigan';
        $states['MN'] = 'Minnesota';
        $states['MS'] = 'Mississippi';
        $states['MO'] = 'Missouri';
        $states['MT'] = 'Montana';
        $states['NE'] = 'Nebraska';
        $states['NV'] = 'Nevada';
        $states['NH'] = 'New Hampshire';
        $states['NJ'] = 'New Jersey';
        $states['NM'] = 'New Mexico';
        $states['NY'] = 'New York';
        $states['NC'] = 'North Carolina';
        $states['ND'] = 'North Dakota';
        $states['OH'] = 'Ohio';
        $states['OK'] = 'Oklahoma';
        $states['OR'] = 'Oregon';
        $states['PA'] = 'Pennsylvania';
        $states['RI'] = 'Rhode Island';
        $states['SC'] = 'South Carolina';
        $states['SD'] = 'South Dakota';
        $states['TN'] = 'Tennessee';
        $states['TX'] = 'Texas';
        $states['UT'] = 'Utah';
        $states['VT'] = 'Vermont';
        $states['VA'] = 'Virginia';
        $states['WA'] = 'Washington';
        $states['DC'] = 'Washington D.C.';
        $states['WV'] = 'West Virginia';
        $states['WI'] = 'Wisconsin';
        $states['WY'] = 'Wyoming';
        $states['AE'] = 'US Forces Europe';
        $states['AP'] = 'US Forces Pacific';
        $states['AA'] = 'US Forces Asia';
        $states['PR'] = 'Puerto Rico';

        return ['States' => $states, 'Provinces' => $provinces, null => 'Other (See next field)'];
    }


    public static function countries()
    {
        $countries = array();
        $countries[] = 'USA';
        $countries[] = 'Canada';
        $countries[] = 'United Kingdom';
        $countries[] = 'Australia';
        $countries[] = 'New Zealand';
        $countries[] = 'Germany';
        $countries[] = 'Albania';
        $countries[] = 'Algeria';
        $countries[] = 'American Samoa';
        $countries[] = 'Andorra';
        $countries[] = 'Angola';
        $countries[] = 'Anguilla';
        $countries[] = 'Antarctica';
        $countries[] = 'Antigua';
        $countries[] = 'Argentina';

        $countries[] = 'Armenia';
        $countries[] = 'Aruba';
        $countries[] = 'Australia';
        $countries[] = 'Austria';
        $countries[] = 'Azerbaijan';
        $countries[] = 'Bahamas';
        $countries[] = 'Bahrain';
        $countries[] = 'Bangladesh';
        $countries[] = 'Barbados';

        $countries[] = 'Barbuda';
        $countries[] = 'Belarus';
        $countries[] = 'Belgium';
        $countries[] = 'Belize';
        $countries[] = 'Benin';
        $countries[] = 'Bermuda';
        $countries[] = 'Bhutan';
        $countries[] = 'Bolivia';
        $countries[] = 'Bosnia';

        $countries[] = 'Botswana';
        $countries[] = 'Bouvet Island';
        $countries[] = 'Brazil';
        $countries[] = 'British Indian Ocean Trty.';
        $countries[] = 'Brunei Darussalam';
        $countries[] = 'Bulgaria';
        $countries[] = 'Burkina Faso';
        $countries[] = 'Burundi';
        $countries[] = 'Caicos Islands';

        $countries[] = 'Cambodia';
        $countries[] = 'Cameroon';
        $countries[] = 'Canada';
        $countries[] = 'Cape Verde';
        $countries[] = 'Cayman Islands';
        $countries[] = 'Central African Republic';
        $countries[] = 'Chad';
        $countries[] = 'Chile';
        $countries[] = 'China';

        $countries[] = 'Christmas Island';
        $countries[] = 'Cocos and Keeling Islands';
        $countries[] = 'Colombia';
        $countries[] = 'Comoros';
        $countries[] = 'Congo';
        $countries[] = 'Cook Islands';
        $countries[] = 'Costa Rica';

        $countries[] = "Cote D'Ivoire";
        $countries[] = 'Croatia';
        $countries[] = 'Cuba';
        $countries[] = 'Cyprus';
        $countries[] = 'Czech Republic';
        $countries[] = 'Denmark';
        $countries[] = 'Djibouti';
        $countries[] = 'Dominica';
        $countries[] = 'Dominican Republic';

        $countries[] = 'East Timor';
        $countries[] = 'Ecuador';
        $countries[] = 'Egypt';
        $countries[] = 'El Salvador';
        $countries[] = 'Equatorial Guinea';
        $countries[] = 'Eritrea';
        $countries[] = 'Estonia';
        $countries[] = 'Ethiopia';
        $countries[] = 'Falkland Islands';

        $countries[] = 'Faroe Islands';
        $countries[] = 'Fiji';
        $countries[] = 'Finland';
        $countries[] = 'France';
        $countries[] = 'French Guiana';
        $countries[] = 'French Polynesia';
        $countries[] = 'French Southern Territories';
        $countries[] = 'Futuna Islands';

        $countries[] = 'Gabon';
        $countries[] = 'Gambia';
        $countries[] = 'Georgia';
        $countries[] = 'Germany';
        $countries[] = 'Ghana';
        $countries[] = 'Gibraltar';
        $countries[] = 'Greece';
        $countries[] = 'Greenland';
        $countries[] = 'Grenada';

        $countries[] = 'Guadeloupe';
        $countries[] = 'Guam';
        $countries[] = 'Guatemala';
        $countries[] = 'Guinea';
        $countries[] = 'Guinea-Bissau';
        $countries[] = 'Guyana';
        $countries[] = 'Haiti';
        $countries[] = 'Heard';
        $countries[] = 'Herzegovina';

        $countries[] = 'Honduras';
        $countries[] = 'Hong Kong';
        $countries[] = 'Hungary';
        $countries[] = 'Iceland';
        $countries[] = 'India';
        $countries[] = 'Indonesia';
        $countries[] = 'Islamic Republic of Iran';
        $countries[] = 'Iraq';

        $countries[] = 'Ireland';
        $countries[] = 'Israel';
        $countries[] = 'Italy';
        $countries[] = 'Jamaica';
        $countries[] = 'Jan Mayen Islands';
        $countries[] = 'Japan';
        $countries[] = 'Jordan';
        $countries[] = 'Kazakhstan';
        $countries[] = 'Kenya';

        $countries[] = 'Kiribati';
        $countries[] = 'South Korea';
        $countries[] = 'Kuwait';
        $countries[] = 'Kyrgystan';
        $countries[] = 'Laos';
        $countries[] = 'Latvia';
        $countries[] = 'Lebanon';

        $countries[] = 'Lesotho';
        $countries[] = 'Liberia';
        $countries[] = 'Libyan Arab Jamahiriya';
        $countries[] = 'Liechtenstein';
        $countries[] = 'Lithuania';
        $countries[] = 'Luxembourg';
        $countries[] = 'Macau';
        $countries[] = 'Madagascar';
        $countries[] = 'Malawi';

        $countries[] = 'Malaysia';
        $countries[] = 'Maldives';
        $countries[] = 'Mali';
        $countries[] = 'Malta';
        $countries[] = 'Marshall Islands';
        $countries[] = 'Martinique';
        $countries[] = 'Mauritania';
        $countries[] = 'Mauritius';
        $countries[] = 'Mayotte';

        $countries[] = 'Mc Donald Islands';
        $countries[] = 'Mexico';
        $countries[] = 'Micronesia';
        $countries[] = 'Miquelon';
        $countries[] = 'Moldova';
        $countries[] = 'Monaco';
        $countries[] = 'Mongolia';
        $countries[] = 'Montserrat';
        $countries[] = 'Morocco';

        $countries[] = 'Mozambique';
        $countries[] = 'Myanmar';
        $countries[] = 'Namibia';
        $countries[] = 'Nauru';
        $countries[] = 'Nepal';
        $countries[] = 'Netherlands';
        $countries[] = 'Netherlands Antilles';
        $countries[] = 'Neutral Zone';
        $countries[] = 'Nevis';

        $countries[] = 'New Caledonia';
        $countries[] = 'New Zealand';
        $countries[] = 'Nicaragua';
        $countries[] = 'Niger';
        $countries[] = 'Nigeria';
        $countries[] = 'Niue';
        $countries[] = 'Norfolk Island';
        $countries[] = 'Northern Mariana Islands';
        $countries[] = 'Norway';

        $countries[] = 'Oman';
        $countries[] = 'Pakistan';
        $countries[] = 'Palau';
        $countries[] = 'Panama';
        $countries[] = 'Papua New Guinea';
        $countries[] = 'Paraguay';
        $countries[] = 'Peru';
        $countries[] = 'Philippines';
        $countries[] = 'Pitcairn';

        $countries[] = 'Poland';
        $countries[] = 'Portugal';
        $countries[] = 'Principe';
        $countries[] = 'Puerto Rico';
        $countries[] = 'Qatar';
        $countries[] = 'Reunion';
        $countries[] = 'Romania';
        $countries[] = 'Russian Federation';
        $countries[] = 'Rwanda';

        $countries[] = 'Saint Helena';
        $countries[] = 'Saint Kitts';
        $countries[] = 'Saint Lucia';
        $countries[] = 'Saint Pierre';
        $countries[] = 'Saint Vincent';
        $countries[] = 'Samoa';
        $countries[] = 'San Marino';
        $countries[] = 'Sao Tome';
        $countries[] = 'Saudi Arabia';

        $countries[] = 'Senegal';
        $countries[] = 'Seychelles';
        $countries[] = 'Sierra Leone';
        $countries[] = 'Singapore';
        $countries[] = 'Slovakia';
        $countries[] = 'Slovenia';
        $countries[] = 'Solomon Islands';
        $countries[] = 'Somalia';
        $countries[] = 'South Africa';

        $countries[] = 'South Georgia';
        $countries[] = 'South Sandwich Islands';
        $countries[] = 'Spain';
        $countries[] = 'Sri Lanka';
        $countries[] = 'Sudan';
        $countries[] = 'Suriname';
        $countries[] = 'Svalbard';
        $countries[] = 'Swaziland';
        $countries[] = 'Sweden';

        $countries[] = 'Switzerland';
        $countries[] = 'Syrian Arab Republic';
        $countries[] = 'Taiwan';
        $countries[] = 'Tajikistan';
        $countries[] = 'Tanzania';
        $countries[] = 'Thailand';
        $countries[] = 'The Grenadines';
        $countries[] = 'Tobago';
        $countries[] = 'Togo';

        $countries[] = 'Tokelau';
        $countries[] = 'Tonga';
        $countries[] = 'Trinidad';
        $countries[] = 'Tunisia';
        $countries[] = 'Turkey';
        $countries[] = 'Turkmenistan';
        $countries[] = 'Turks Islands';
        $countries[] = 'Tuvalu';
        $countries[] = 'Uganda';

        $countries[] = 'Ukraine';
        $countries[] = 'United Arab Emirates';
        $countries[] = 'United Kingdom';
        $countries[] = 'United States';
        $countries[] = 'USA';
        $countries[] = 'Uruguay';
        $countries[] = 'US Minor Outlying Islands';
        $countries[] = 'Uzbekistan';
        $countries[] = 'Vanuatu';
        $countries[] = 'Vatican City State';

        $countries[] = 'Venezuela';
        $countries[] = 'VietNam';
        $countries[] = 'Virgin Islands British';
        $countries[] = 'Virgin Islands USA';
        $countries[] = 'Wallis';
        $countries[] = 'Western Sahara';
        $countries[] = 'Yemen';
        $countries[] = 'Yugoslavia';

        $countries[] = 'Zaire';
        $countries[] = 'Zimbabwe';

        return array_combine($countries, $countries);
    }


    public static function years()
    {
        $currentYear = date('Y');
        $years = range(($currentYear - 2), ($currentYear + 10));
        return array_combine($years, $years);
    }


    public static function months()
    {
        $months = array();
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


    public static function days()
    {
        $days = range(1, 31);
        return array_combine($days, $days);
    }


    public static function fetchOptionTypes($class)
    {
        $sorted = $class::orderBy('sort_order')->get();
        $data = [];
        $sorted->map(function ($item, $key) use (&$data) {
            $data[$item->code] = $item->display_text;
        });
        return $data;
    }
}
