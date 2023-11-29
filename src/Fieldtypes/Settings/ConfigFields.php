<?php

namespace WithCandour\StatamicAdvancedForms\Fieldtypes\Settings;

class ConfigFields 
{
    public static function enableAutocomplete()
    {
        return [
            'display' => 'Enable Autocomplete',
            'instructions' => 'When active, the field will pull autocomplete values from the browser.',
            'type' => 'toggle',
            'default' => false,
            'width' => 100
        ];
    }

    public static function autocompleteAttribute()
    {
        return [
            'display' => 'Autocomplete Attribute',
            'instructions' => 'When autocomplete is active, you can specify which attribute you would like to select.',
            'type' => 'select',
            'width' => 100,
            'options' => [
                'on' => 'On',
                'name' => 'Name',
                'honorific-prefix' => 'Honorific Prefix (Mr, Miss, Dr, etc)',
                'given-name' => 'Given Name (First Name)',
                'additional-name' => 'Additional Name (Middle Name)',
                'family-name' => 'Family Name (Last Name)',
                'honorific-suffix' => 'Honorific Suffix (Jr, B.Sc, PhD, etc)',
                'nickname' => 'Nickname',
                'email' => 'Email Address',
                'username' => 'Username',
                'organization-title' => 'Organisation Title',
                'organization' => 'Organisation',
                'address-line1' => 'Address Line 1',
                'address-line2' => 'Address Line 2',
                'address-line3' => 'Address Line 3',
                'address-level1' => 'Address Level 1 (First Administrative Level)',
                'address-level2' => 'Address Level 2 (Second Administrative Level)',
                'address-level3' => 'Address Level 3 (Third Administrative Level)',
                'address-level4' => 'Address Level 4 (Fourth Administrative Level)',
                'country' => 'Country',
                'country-name' => 'Country Name',
                'postal-code' => 'Post Code',
                'bday' => 'Birthday',
                'bday-day' => 'Birthday Day',
                'bday-month' => 'Birthday Month',
                'bday-year' => 'Birthday Year',
                'sex' => 'Sex',
                'tel' => 'Telephone Number',
                'tel-country-code' => 'Telephone Country Code',
                'tel-national' => 'Telephone Number without Country Code',
                'tel-area-code' => 'Telephone Area Code',
                'tel-local' => 'Telephone Number without Country Code or Area Code',
                'tel-extension' => 'Telephone Extension',
                'impp' => 'IMPP',
                'url' => 'URL',
                'photo' => 'Photo'
            ],
            'if' => [
                'autocomplete' => 'equals true'
            ],
            'default' => 'on',
        ];
    }

    public static function enableDynamicPopulation()
    {
        return [
            'display' => 'Enable Dynamic Population',
            'instructions' => 'When active, the field will pull the value from a GET parameter in a URL of the same name as the field handle.',
            'type' => 'toggle',
            'default' => false
        ];
    }

    public static function disableDuplicates()
    {
        return [
            'display' => 'Disable Duplicates',
            'instructions' => 'This is useful if you want to limit submissions to one per email address, for example.',
            'type' => 'toggle',
            'default' => false
        ];
    }

    public static function enableCalculations()
    {
        return [
            'display' => 'Enable Calculations',
            'instructions' => 'This is useful if you want to dynamically populate a field based on a formula.',
            'type' => 'toggle',
            'default' => false
        ];
    }

    public static function calculation()
    {
        return [
            'display' => 'Calculation Formula',
            'instructions' => 'Write your math formula in here using `[form_handle]` as a shortcode. This does not support the use of brackets.',
            'type' => 'calculator',
            'width' => 100,
            'if' => [
                'enable_calculations' => 'equals true'
            ]
        ];
    }

    public static function enableInputMask()
    {
        return [
            'display' => 'Enable Input Mask',
            'instructions' => 'When active, you can specify an input mask to be applied to the field.',
            'type' => 'toggle',
            'default' => false,
            'width' => 100
        ];
    }

    public static function enableCustomMask()
    {
        return [
            'display' => 'Enable Custom Input Mask',
            'instructions' => 'When active, you can specify your own input mask patterns.',
            'type' => 'toggle',
            'default' => false,
            'width' => 100,
            'if' => [
                'enable_input_mask' => 'equals true'
            ]
        ];
    }

    public static function customMask()
    {
        return [
            'display' => 'Custom Input Mask',
            'instructions' => 'Custom Input Mask',
            'type' => 'text',
            'default' => false,
            'width' => 100,
            'if' => [
                'enable_input_mask' => 'equals true',
                'enable_custom_mask' => 'equals true'
            ]
        ];
    }

    public static function maskFieldMaskSettings() 
    {
        return [
            'display' => 'Mask Settings',
            'type' => 'select',
            'width' => 100,
            'options' => [
                '{+44} (\\0) 0000-000-000' => 'UK Phone Number Inc Country Code',
                '00000 000 000' => 'UK Phone Number Format',
                '00/00/0000' => 'Date Format (DD/MM/YYYY)',
                '00-00-0000' => 'Date Format (DD-MM-YYYY)',
                '00.00.0000' => 'Date Format (DD.MM.YYYY)',
                'aa 00 00 00 a' => 'UK National Insurance Number',
                'aa0[0] 0aa' => 'UK Postcode'
            ],
            'if' => [
                'enable_input_mask' => 'equals true',
                'enable_custom_mask' => 'not equals true'
            ]
        ];
    }

    public static function numberFieldMaskSettings() 
    {
        return [
            'display' => 'Mask Settings',
            'type' => 'select',
            'width' => 100,
            'options' => [
                '{+44} (\\0) 0000-000-000' => 'UK Phone Number Inc Country Code',
                '00000 000 000' => 'UK Phone Number Format',
                '00/00/0000' => 'Date Format (DD/MM/YYYY)',
                '00-00-0000' => 'Date Format (DD-MM-YYYY)',
                '00.00.0000' => 'Date Format (DD.MM.YYYY)',
                'currency' => 'Currency Format'
            ],
            'if' => [
                'enable_input_mask' => 'equals true',
                'enable_custom_mask' => 'not equals true'
            ]
        ];
    }

    public static function currencySymbol() 
    {
        return [
            'display' => 'Currency Symbol',
            'type' => 'select',
            'width' => 100,
            'options' => [
                '£' => 'GBP',
                '$' => 'Dollar',
                '€' => 'Euro'
            ],
            'if' => [
                'enable_input_mask' => 'equals true',
                'mask_settings' => 'equals currency'
            ]
        ];
    }
}