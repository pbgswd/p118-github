<?php

namespace App\Models;

use function array_combine;

/**
 * Class Countries
 * @package App\Models
 */


class Countries
{
    public static function countries(): array
    {
        $countries = [];
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
}
