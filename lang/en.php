<?php
// ============================================================================
// File:    en.php
// Author:  Recep Seymen Konuk <konukrecepseymen@gmail.com>
//
// Licensed under the terms of the LICENSE file in the project root directory.
// ============================================================================

return [
    // General
    'required' => 'This field is required!',
    'invalid' => 'This field is invalid!',
    'not_nullable' => 'This field cannot be null!',

    // Types
    'integer' => 'This field must be an integer!',
    'float' => 'This field must be a floating-point number!',
    'boolean' => 'This field must be a boolean!',
    'string' => 'This field must be a string!',
    'array' => 'This field must be an array!',
    'datetime' => 'This field must be a valid datetime!',

    // String formats
    'email' => 'This field must be a valid email address!',
    'url' => 'This field must be a valid URL!',
    'uuid' => 'This field must be a valid UUID!',
    'slug' => 'This field must be a valid slug!',
    'alpha' => 'This field may only contain letters!',
    'alphanumeric' => 'This field may only contain letters and numbers!',
    'numeric' => 'This field must be numeric!',
    'secure_password' => 'This field must be a strong password!',

    // Arrays
    'distinct' => 'This array must contain unique values!',
    'count' => 'This array must contain exactly {count} items!',
    'min_count' => 'This array must contain at least {count} items!',
    'max_count' => 'This array may not contain more than {count} items!',
    'items' => 'One or more array items are invalid: {message}',

    // Boolean
    'accepted' => 'This field must be {value}!',

    // Enum
    'enum' => 'This field must be one of: {values}!',

    // DateTime
    'date_equals' => 'This field must be {datetime}!',
    'date_after' => 'This field must be after {datetime}!',
    'date_before' => 'This field must be before {datetime}!',

    // Numeric values
    'equals' => 'This field must be {value}!',
    'min' => 'This field must be at least {value}!',
    'max' => 'This field may not be greater than {value}!',

    // String lengths
    'length' => 'This field must be exactly {length} characters!',
    'min_length' => 'This field must be at least {length} characters!',
    'max_length' => 'This field may not be greater than {length} characters!',
];
