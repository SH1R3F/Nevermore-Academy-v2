<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Spreadsheet service
    |--------------------------------------------------------------------------
    |
    | This option controls the default service that is used to deal with
    | third-party spreadsheets of your application. 
    |
    */

    'default' => env('SHEET_DEFAULT', 'google'),

    /*
    |--------------------------------------------------------------------------
    | Default Google sheets configuration
    |--------------------------------------------------------------------------
    |
    | Here you may configure all of the sheets configuration used by your
    | application plus their respective settings.
    |
    */
    'google' => [
        "type" => "service_account",
        "project_id" => "inspiring-modem-370612",
        "private_key_id" => env('GOOGLE_PRIVATE_KEY_ID'),
        "private_key" => env('GOOGLE_PRIVATE_KEY'),
        "client_email" => env('GOOGLE_CLIENT_EMAIL'),
        "client_id" => env('GOOGLE_CLIENT_ID'),
        "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
        "token_uri" => "https://oauth2.googleapis.com/token",
        "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
        "client_x509_cert_url" => env('GOOGLE_CLIENT_X509_CERT_URL')
    ]

];
