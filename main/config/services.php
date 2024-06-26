<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

  'mailgun' => [
    'domain' => env('MAILGUN_DOMAIN'),
    'secret' => env('MAILGUN_SECRET'),
    'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
  ],

  'postmark' => [
    'token' => env('POSTMARK_TOKEN'),
  ],

  'ses' => [
    'key' => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
  ],
  'paystack' => [
    'initialisation_url' => env('PAYSTACK_INITIALISATION_URL', null),
    'verification_url' => env('PAYSTACK_VERIFICATION_URL', null),
    'charge_authorization_url' => env('PAYSTACK_CHARGE_AUTHORIZATION_URL', null),
    'secret_key' => env('PAYSTACK_SECRET_KEY', null),
  ],
  'bulk_sms' => [
    'endpoint' => 'https://www.bulksmsnigeria.com/api/v1/sms/create',
    'api_token' => env('BULK_SMS_API_TOKEN'),
    'from' => env('BULK_SMS_SENDER_ID'),
  ],

];
