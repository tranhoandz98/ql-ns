<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Trường following language lines contain Trường default error messages used by
    | Trường validator class. Some of these rules have multiple versions such
    | as Trường size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'Trường :attribute must be accepted.',
    'accepted_if' => 'Trường :attribute must be accepted when :other is :value.',
    'active_url' => 'Trường :attribute is not a valid URL.',
    'after' => 'Trường :attribute must be a date after :date.',
    'after_or_equal' => 'Trường :attribute must be a date after or equal to :date.',
    'alpha' => 'Trường :attribute must only contain letters.',
    'alpha_dash' => 'Trường :attribute must only contain letters, numbers, dashes and underscores.',
    'alpha_num' => 'Trường :attribute must only contain letters and numbers.',
    'array' => 'Trường :attribute must be an array.',
    'before' => 'Trường :attribute must be a date before :date.',
    'before_or_equal' => 'Trường :attribute must be a date before or equal to :date.',
    'between' => [
        'numeric' => 'Trường :attribute must be between :min and :max.',
        'file' => 'Trường :attribute must be between :min and :max kilobytes.',
        'string' => 'Trường :attribute must be between :min and :max characters.',
        'array' => 'Trường :attribute must have between :min and :max items.',
    ],
    'boolean' => 'Trường :attribute field must be true or false.',
    'confirmed' => 'Trường :attribute confirmation does not match.',
    'current_password' => 'Trường password is incorrect.',
    'date' => 'Trường :attribute is not a valid date.',
    'date_equals' => 'Trường :attribute must be a date equal to :date.',
    'date_format' => 'Trường :attribute does not match Trường format :format.',
    'declined' => 'Trường :attribute must be declined.',
    'declined_if' => 'Trường :attribute must be declined when :other is :value.',
    'different' => 'Trường :attribute and :other must be different.',
    'digits' => 'Trường :attribute must be :digits digits.',
    'digits_between' => 'Trường :attribute must be between :min and :max digits.',
    'dimensions' => 'Trường :attribute has invalid image dimensions.',
    'distinct' => 'Trường :attribute field has a duplicate value.',
    'email' => 'Trường :attribute must be a valid email address.',
    'ends_with' => 'Trường :attribute must end with one of Trường following: :values.',
    'enum' => 'Trường selected :attribute is invalid.',
    'exists' => 'Trường selected :attribute is invalid.',
    'file' => 'Trường :attribute must be a file.',
    'filled' => 'Trường :attribute field must have a value.',
    'gt' => [
        'numeric' => 'Trường :attribute must be greater than :value.',
        'file' => 'Trường :attribute must be greater than :value kilobytes.',
        'string' => 'Trường :attribute must be greater than :value characters.',
        'array' => 'Trường :attribute must have more than :value items.',
    ],
    'gte' => [
        'numeric' => 'Trường :attribute must be greater than or equal to :value.',
        'file' => 'Trường :attribute must be greater than or equal to :value kilobytes.',
        'string' => 'Trường :attribute must be greater than or equal to :value characters.',
        'array' => 'Trường :attribute must have :value items or more.',
    ],
    'image' => 'Trường :attribute must be an image.',
    'in' => 'Trường selected :attribute is invalid.',
    'in_array' => 'Trường :attribute field does not exist in :other.',
    'integer' => 'Trường :attribute must be an integer.',
    'ip' => 'Trường :attribute must be a valid IP address.',
    'ipv4' => 'Trường :attribute must be a valid IPv4 address.',
    'ipv6' => 'Trường :attribute must be a valid IPv6 address.',
    'json' => 'Trường :attribute must be a valid JSON string.',
    'lt' => [
        'numeric' => 'Trường :attribute must be less than :value.',
        'file' => 'Trường :attribute must be less than :value kilobytes.',
        'string' => 'Trường :attribute must be less than :value characters.',
        'array' => 'Trường :attribute must have less than :value items.',
    ],
    'lte' => [
        'numeric' => 'Trường :attribute must be less than or equal to :value.',
        'file' => 'Trường :attribute must be less than or equal to :value kilobytes.',
        'string' => 'Trường :attribute must be less than or equal to :value characters.',
        'array' => 'Trường :attribute must not have more than :value items.',
    ],
    'mac_address' => 'Trường :attribute must be a valid MAC address.',
    'max' => [
        'numeric' => 'Trường :attribute không được lớn hơn :max.',
        'file' => 'Trường :attribute không được lớn hơn :max KB.',
        'string' => 'Trường :attribute không được lớn hơn :max kí tự.',
        'array' => 'Trường :attribute phải có nhiều nhất :max mục.',
    ],
    'mimes' => 'Trường :attribute must be a file of type: :values.',
    'mimetypes' => 'Trường :attribute must be a file of type: :values.',
    'min' => [
        'numeric' => 'Trường :attribute không được nhỏ hơn :min.',
        'file' => 'Trường :attribute không được nhỏ hơn :min KB.',
        'string' => 'Trường :attribute không được nhỏ hơn :min kí tự.',
        'array' => 'Trường :attribute phải có ít nhất :min mục.',
    ],
    'multiple_of' => 'Trường :attribute must be a multiple of :value.',
    'not_in' => 'Trường selected :attribute is invalid.',
    'not_regex' => 'Trường :attribute format is invalid.',
    'numeric' => 'Trường :attribute must be a number.',
    'password' => 'Trường password is incorrect.',
    'present' => 'Trường :attribute field must be present.',
    'prohibited' => 'Trường :attribute field is prohibited.',
    'prohibited_if' => 'Trường :attribute field is prohibited when :other is :value.',
    'prohibited_unless' => 'Trường :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'Trường :attribute field prohibits :other from being present.',
    'regex' => 'Trường :attribute format is invalid.',
    'required' => 'Trường :attribute là bắt buộc.',
    'required_array_keys' => 'Trường :attribute field must contain entries for: :values.',
    'required_if' => 'Trường :attribute field is required when :other is :value.',
    'required_unless' => 'Trường :attribute field is required unless :other is in :values.',
    'required_with' => 'Trường :attribute field is required when :values is present.',
    'required_with_all' => 'Trường :attribute field is required when :values are present.',
    'required_without' => 'Trường :attribute field is required when :values is not present.',
    'required_without_all' => 'Trường :attribute field is required when none of :values are present.',
    'same' => 'Trường :attribute and :other must match.',
    'size' => [
        'numeric' => 'Trường :attribute must be :size.',
        'file' => 'Trường :attribute must be :size kilobytes.',
        'string' => 'Trường :attribute must be :size characters.',
        'array' => 'Trường :attribute must contain :size items.',
    ],
    'starts_with' => 'Trường :attribute must start with one of Trường following: :values.',
    'string' => 'Trường :attribute must be a string.',
    'timezone' => 'Trường :attribute must be a valid timezone.',
    'unique' => 'Trường :attribute đã tồn tại.',
    'uploaded' => 'Trường :attribute failed to upload.',
    'url' => 'Trường :attribute must be a valid URL.',
    'uuid' => 'Trường :attribute must be a valid UUID.',

    'phone_length' => 'Trường :attribute phải từ 9-15 kí tự.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name Trường lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
