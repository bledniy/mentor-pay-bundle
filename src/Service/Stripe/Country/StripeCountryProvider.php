<?php

namespace AppPaymentClient\Service\Stripe\Country;

class StripeCountryProvider
{
    /**
     * @var string[]
     */
    private static $countries = [
//        'AU' => 'Australia',
        'AT' => 'Austria',
        'BE' => 'Belgium',
//        'BR' => 'Brazil',
        'BG' => 'Bulgaria',
//        'CA' => 'Canada',
        'HR' => 'Croatia',
        'CY' => 'Cyprus',
        'CZ' => 'Czech Republic',
        'DK' => 'Denmark',
        'EE' => 'Estonia',
        'FI' => 'Finland',
        'FR' => 'France',
        'DE' => 'Germany',
//        'GI' => 'Gibraltar',
        'GR' => 'Greece',
//        'HK' => 'Hong Kong',
        'HU' => 'Hungary',
//        'IN' => 'India',
        'IE' => 'Ireland',
        'IT' => 'Italy',
//        'JP' => 'Japan',
        'LV' => 'Latvia',
        'LI' => 'Liechtenstein',
        'LT' => 'Lithuania',
        'LU' => 'Luxembourg',
//        'MY' => 'Malaysia',
        'MT' => 'Malta',
//        'MX' => 'Mexico',
        'NL' => 'Netherlands',
//        'NZ' => 'New Zealand',
        'NO' => 'Norway',
        'PL' => 'Poland',
        'PT' => 'Portugal',
        'RO' => 'Romania',
//        'SG' => 'Singapore',
        'SK' => 'Slovakia',
        'SI' => 'Slovenia',
        'ES' => 'Spain',
        'SE' => 'Sweden',
        'CH' => 'Switzerland',
//        'AE' => 'United Arab Emirates',
        'GB' => 'United Kingdom',
//        'US' => 'United States',
//        'ID' => 'Indonesia',
//        'TH' => 'Thailand',
//        'PH' => 'Philippines',
    ];

    /**
     * @return string[]
     */
    public static function getCountries(): array
    {
        return self::$countries;
    }
}