<?php

return [

  /*
    |--------------------------------------------------------------------------
    | Application Name
    |--------------------------------------------------------------------------
    |
    | This value is the name of your application. This value is used when the
    | framework needs to place the application's name in a notification or
    | any other location as required by the application or its packages.
    |
    */

  'name' => env('APP_NAME', null),
  'phone' => env('APP_PHONE', null),
  'email' => env('APP_EMAIL', null),
  'address' => env('APP_ADDRESS', null),
  'whatsapp' => env('APP_WHATSAPP', null),
  'facebook' => env('APP_FACEBOOK', null),
  'instagram' => env('APP_INSTAGRAM', null),
  'twitter' => env('APP_TWITTER', null),

  /*
    |--------------------------------------------------------------------------
    | Core Savings Interest Rate
    |--------------------------------------------------------------------------
    |
    |The interest rate that will be applied to all core savings.
    |
    */

  'balance_before_bvn_validation' => env('BALANCE_BEFORE_BVN_VALIDATION', 5000),

  /*
    |--------------------------------------------------------------------------
    | Core Savings Interest Rate
    |--------------------------------------------------------------------------
    |
    |The interest rate that will be applied to all core savings.
    |
    */

  'core_savings_interest_rate' => env('CORE_SAVINGS_INTEREST_RATE', 0.5),

  /*
    |--------------------------------------------------------------------------
    | GOS Interest Rate
    |--------------------------------------------------------------------------
    |
    |The interest rate that will be applied to all goal oriented savings.
    |
    */

  'gos_savings_interest_rate' => env('GOS_SAVINGS_INTEREST_RATE', 0.5),

  /*
    |--------------------------------------------------------------------------
    | LOCKED Savings Interest Rate
    |--------------------------------------------------------------------------
    |
    |The interest rate that will be applied to all locked savings.
    |
    */

  'locked_savings_interest_rate' => env('LOCKED_SAVINGS_INTEREST_RATE', 0.5),

  /*
    |--------------------------------------------------------------------------
    | LOCKED Savings Interest Rate
    |--------------------------------------------------------------------------
    |
    |The interest rate that will be applied to all locked savings.
    |
    */

  'days_before_interest_starts_counting' => env('DAYS_BEFORE_INTEREST', 2),

  /*
    |--------------------------------------------------------------------------
    | Smart Loan Interest Rate
    |--------------------------------------------------------------------------
    |
    |The interest rate that will be applied to all smart loans.
    |
    */

  'smart_loan_interest_rate' => env('SMART_LOAN_INTEREST_RATE', 10),

  /*
    |--------------------------------------------------------------------------
    | Smart Loan Duration
    |--------------------------------------------------------------------------
    |
		|	This is the duration in months which the lender has to pay back the loan.
		|	This is minus the grace period.
    |
    */

  'smart_loan_duration' => env('SMART_LOAN_DURATION', 3),

  /*
    |--------------------------------------------------------------------------
    | Smart Loan Grace Period
    |--------------------------------------------------------------------------
    |
    |The grace period in DAYS of default before a loan is automatically wiped
    |
    */

  'smart_loan_grace_period' => env('SMART_LOAN_GRACE_PERIOD', 30),

  /*
    |--------------------------------------------------------------------------
    | Smart Loan Auto Debit Day
    |--------------------------------------------------------------------------
    |
    |	The day of the week when we process loan auto debit repayments
    |
    */

  'smart_loan_weekly_auto_debit_day' => env('SMART_LOAN_WEEKLY_AUTO_DEBIT_DAY', 'friday'),
  'smart_loan_monthly_auto_debit_day' => env('SMART_LOAN_MONTHLY_AUTO_DEBIT_DAY', 23),

  /*
    |--------------------------------------------------------------------------
    | Undue Withdrawal Charges
    |--------------------------------------------------------------------------
    |
		|	User can only withdraw once a month within a 20 day interval without charges.
		| Any additional withdrawal will attract a charge
    |
    */

  'undue_withdrawal_charge_percentage' => env('UNDUE_WITHDRAWAL_CHARGE_PERCENTAGE', 5),

  /*
    |--------------------------------------------------------------------------
    | Lock Break Percentage Charge
    |--------------------------------------------------------------------------
    |
		|	User can only withdraw once a month within a 20 day interval without charges.
		| Any additional withdrawal will attract a charge
    |
    */

  'lock_break_percentage_charge' => env('LOCK_BREAK_PERCENTAGE_CHARGE', 20),

  /*
    |--------------------------------------------------------------------------
    | Application Environment
    |--------------------------------------------------------------------------
    |
    | This value determines the "environment" your application is currently
    | running in. This may determine how you prefer to configure various
    | services the application utilizes. Set this in your ".env" file.
    |
    */

  'env' => env('APP_ENV', 'production'),

  /*
    |--------------------------------------------------------------------------
    | Application Debug Mode
    |--------------------------------------------------------------------------
    |
    | When your application is in debug mode, detailed error messages with
    | stack traces will be shown on every error that occurs within your
    | application. If disabled, a simple generic error page is shown.
    |
    */

  'debug' => env('APP_DEBUG', false),

  /*
    |--------------------------------------------------------------------------
    | Application URL
    |--------------------------------------------------------------------------
    |
    | This URL is used by the console to properly generate URLs when using
    | the Artisan command line tool. You should set this to the root of
    | your application so that it is used when running Artisan tasks.
    |
    */

  'url' => env('APP_URL', 'http://localhost'),

  'asset_url' => env('ASSET_URL', null),

  /*
    |--------------------------------------------------------------------------
    | Application Timezone
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default timezone for your application, which
    | will be used by the PHP date and date-time functions. We have gone
    | ahead and set this to a sensible default for you out of the box.
    |
    */

  'timezone' => 'UTC',

  /*
    |--------------------------------------------------------------------------
    | Application Locale Configuration
    |--------------------------------------------------------------------------
    |
    | The application locale determines the default locale that will be used
    | by the translation service provider. You are free to set this value
    | to any of the locales which will be supported by the application.
    |
    */

  'locale' => 'en',

  /*
    |--------------------------------------------------------------------------
    | Application Fallback Locale
    |--------------------------------------------------------------------------
    |
    | The fallback locale determines the locale to use when the current one
    | is not available. You may change the value to correspond to any of
    | the language folders that are provided through your application.
    |
    */

  'fallback_locale' => 'en',

  /*
    |--------------------------------------------------------------------------
    | Faker Locale
    |--------------------------------------------------------------------------
    |
    | This locale will be used by the Faker PHP library when generating fake
    | data for your database seeds. For example, this will be used to get
    | localized telephone numbers, street address information and more.
    |
    */

  'faker_locale' => 'en_US',

  /*
    |--------------------------------------------------------------------------
    | Encryption Key
    |--------------------------------------------------------------------------
    |
    | This key is used by the Illuminate encrypter service and should be set
    | to a random, 32 character string, otherwise these encrypted strings
    | will not be safe. Please do this before deploying an application!
    |
    */

  'key' => env('APP_KEY'),

  'cipher' => 'AES-256-CBC',

  /*
    |--------------------------------------------------------------------------
    | Autoloaded Service Providers
    |--------------------------------------------------------------------------
    |
    | The service providers listed here will be automatically loaded on the
    | request to your application. Feel free to add your own services to
    | this array to grant expanded functionality to your applications.
    |
    */

  'providers' => [

    /*
         * Laravel Framework Service Providers...
         */
    Illuminate\Auth\AuthServiceProvider::class,
    Illuminate\Broadcasting\BroadcastServiceProvider::class,
    Illuminate\Bus\BusServiceProvider::class,
    Illuminate\Cache\CacheServiceProvider::class,
    Illuminate\Foundation\Providers\ConsoleSupportServiceProvider::class,
    Illuminate\Cookie\CookieServiceProvider::class,
    Illuminate\Database\DatabaseServiceProvider::class,
    Illuminate\Encryption\EncryptionServiceProvider::class,
    Illuminate\Filesystem\FilesystemServiceProvider::class,
    Illuminate\Foundation\Providers\FoundationServiceProvider::class,
    Illuminate\Hashing\HashServiceProvider::class,
    Illuminate\Mail\MailServiceProvider::class,
    Illuminate\Notifications\NotificationServiceProvider::class,
    Illuminate\Pagination\PaginationServiceProvider::class,
    Illuminate\Pipeline\PipelineServiceProvider::class,
    Illuminate\Queue\QueueServiceProvider::class,
    // Illuminate\Redis\RedisServiceProvider::class,
    Illuminate\Auth\Passwords\PasswordResetServiceProvider::class,
    Illuminate\Session\SessionServiceProvider::class,
    Illuminate\Translation\TranslationServiceProvider::class,
    Illuminate\Validation\ValidationServiceProvider::class,
    Illuminate\View\ViewServiceProvider::class,

    /*
         * Package Service Providers...
         */

    /*
         * Application Service Providers...
         */
    App\Providers\AppServiceProvider::class,
    App\Providers\AuthServiceProvider::class,
    // App\Providers\BroadcastServiceProvider::class,
    App\Providers\EventServiceProvider::class,
    App\Providers\RouteServiceProvider::class,

  ],

  /*
    |--------------------------------------------------------------------------
    | Class Aliases
    |--------------------------------------------------------------------------
    |
    | This array of class aliases will be registered when this application
    | is started. However, feel free to register as many as you wish as
    | the aliases are "lazy" loaded so they don't hinder performance.
    |
    */

  'aliases' => [

    'App' => Illuminate\Support\Facades\App::class,
    'Arr' => Illuminate\Support\Arr::class,
    'Artisan' => Illuminate\Support\Facades\Artisan::class,
    'Auth' => Illuminate\Support\Facades\Auth::class,
    'Blade' => Illuminate\Support\Facades\Blade::class,
    'Broadcast' => Illuminate\Support\Facades\Broadcast::class,
    'Bus' => Illuminate\Support\Facades\Bus::class,
    'Cache' => Illuminate\Support\Facades\Cache::class,
    'Config' => Illuminate\Support\Facades\Config::class,
    'Cookie' => Illuminate\Support\Facades\Cookie::class,
    'Crypt' => Illuminate\Support\Facades\Crypt::class,
    'DB' => Illuminate\Support\Facades\DB::class,
    'Eloquent' => Illuminate\Database\Eloquent\Model::class,
    'Event' => Illuminate\Support\Facades\Event::class,
    'File' => Illuminate\Support\Facades\File::class,
    'Gate' => Illuminate\Support\Facades\Gate::class,
    'Hash' => Illuminate\Support\Facades\Hash::class,
    'Lang' => Illuminate\Support\Facades\Lang::class,
    'Log' => Illuminate\Support\Facades\Log::class,
    'Mail' => Illuminate\Support\Facades\Mail::class,
    'Notification' => Illuminate\Support\Facades\Notification::class,
    'Password' => Illuminate\Support\Facades\Password::class,
    'Queue' => Illuminate\Support\Facades\Queue::class,
    'Redirect' => Illuminate\Support\Facades\Redirect::class,
    'Redis' => Illuminate\Support\Facades\Redis::class,
    'Request' => Illuminate\Support\Facades\Request::class,
    'Response' => Illuminate\Support\Facades\Response::class,
    'Route' => Illuminate\Support\Facades\Route::class,
    'Schema' => Illuminate\Support\Facades\Schema::class,
    'Session' => Illuminate\Support\Facades\Session::class,
    'Storage' => Illuminate\Support\Facades\Storage::class,
    'Str' => Illuminate\Support\Str::class,
    'URL' => Illuminate\Support\Facades\URL::class,
    'Validator' => Illuminate\Support\Facades\Validator::class,
    'View' => Illuminate\Support\Facades\View::class,

  ],

];
