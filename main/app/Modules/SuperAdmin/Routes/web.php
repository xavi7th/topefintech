<?php

use App\Modules\SuperAdmin\Http\Controllers\SuperAdminController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

SuperAdminController::routes();



// if (!app()->routesAreCached()) {
//     require __DIR__ . '/Http/routes.php';
// }
