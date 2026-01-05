<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\EmailVerificationNotificationController;
use App\Http\Controllers\Auth\GoogleController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\UsernameController;
use App\Http\Controllers\Auth\VerifyEmailController;
use App\Http\Controllers\DocController;
use App\Http\Controllers\CreditDebitController;
use App\Http\Controllers\EricaController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\QrpsController;
use App\Http\Controllers\MiniAtmController;
use App\Http\Controllers\MiniAtmCredentialController;
use App\Http\Controllers\BnplController;
use App\Http\Controllers\App2AppCdcpQrisController;
use App\Http\Controllers\App2AppMiniAtmController;
use App\Http\Controllers\CarlaController;
use App\Http\Controllers\Host2HostCdcpQrpsController;
use App\Http\Controllers\Host2HostCnpController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Support\ApiProxy;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);

    Route::get('/login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('/login', [AuthenticatedSessionController::class, 'store']);

    Route::get('/forgot-password', [PasswordResetLinkController::class, 'create'])
        ->name('password.request');
    Route::post('/forgot-password', [PasswordResetLinkController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('password.email');

    Route::get('/reset-password/{token}', [NewPasswordController::class, 'create'])
        ->name('password.reset');
    Route::post('/reset-password', [NewPasswordController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('password.store');

    Route::get('/auth/google', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
    Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
});

Route::middleware(['auth', 'username.required'])->group(function () {
    Route::get('/set-username', [UsernameController::class, 'create'])->name('username.create');
    Route::post('/set-username', [UsernameController::class, 'store'])->name('username.store');

    Route::get('/verify-email', function () {
        return view('auth.verify-email');
    })->name('verification.notice');

    Route::get('/verify-email/{id}/{hash}', VerifyEmailController::class)
        ->middleware(['signed', 'throttle:6,1'])
        ->name('verification.verify');

    Route::post('/email/verification-notification', [EmailVerificationNotificationController::class, 'store'])
        ->middleware('throttle:6,1')
        ->name('verification.send');

    Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    Route::middleware(['verified', 'profile.complete'])->group(function () {
        Route::get('/dashboard', DashboardController::class)->name('dashboard');

        Route::get('/app2app/cdcp-qris', App2AppCdcpQrisController::class)->name('app2app.cdcp-qris');
        Route::get('/app2app/mini-atm', App2AppMiniAtmController::class)->name('app2app.mini-atm');
        Route::get('/host2host/cdcp-qrps', Host2HostCdcpQrpsController::class)->name('host2host.cdcp-qrps');
        Route::get('/host2host/cnp', Host2HostCnpController::class)->name('host2host.cnp');

        Route::get('/ecr/erica', [EricaController::class, 'index'])->name('erica.index');
        Route::get('/ecr/carla', CarlaController::class)->name('erica.carla');
        Route::post('/erica/generate', [EricaController::class, 'generate'])->name('erica.generate');

        Route::post('/bindings/credit-debit', CreditDebitController::class)->name('bindings.credit-debit');
        Route::post('/bindings/qrps', QrpsController::class)->name('bindings.qrps');
        Route::post('/bindings/mini-atm', MiniAtmController::class)->name('bindings.mini-atm');
        Route::post('/bindings/bnpl', BnplController::class)->name('bindings.bnpl');

        Route::get('/mini-atm', [MiniAtmCredentialController::class, 'index'])->name('mini-atm.index');
        Route::post('/mini-atm/generate', [MiniAtmCredentialController::class, 'generate'])->name('mini-atm.generate');
        Route::post('/mini-atm/regenerate', [MiniAtmCredentialController::class, 'regenerate'])->name('mini-atm.regenerate');
    });
});

Route::get('/docs', [DocController::class, 'index'])->name('docs.index');
Route::get('/docs/{doc}', [DocController::class, 'show'])->name('docs.show');

Route::get('/docs/category/{category:slug}', [DocController::class, 'showCategory'])
     ->name('docs.category.show');

// LAMA: Rute buat nampilin Halaman Postingan/Dokumen
Route::get('/docs/{doc:slug}', [DocController::class, 'show'])
     ->name('docs.show');

Route::get('/api-playground/{spec?}', function ($spec = null) {
    $availableSpecs = config('openapi.specs', []);
    $aliases = config('openapi.aliases', []);
    $defaultSpec = config('openapi.default', 'api-docs');
    $spec = $spec ?: $defaultSpec;
    $resolvedSpec = $aliases[$spec] ?? $spec;

    if (!array_key_exists($resolvedSpec, $availableSpecs)) {
        abort(404);
    }

    return view('docs.api-playground', [
        'specPath' => '/openapi/' . $resolvedSpec,
    ]);
})->name('docs.api-playground');


// route untuk mengambil file openapi spec secara langsung
Route::get('/openapi/{spec}', function ($spec) {
    $availableSpecs = config('openapi.specs', []);
    $aliases = config('openapi.aliases', []);
    $resolvedSpec = $aliases[$spec] ?? $spec;

    if (!array_key_exists($resolvedSpec, $availableSpecs)) {
        abort(404);
    }

    $basePath = public_path('openapi');
    $filePath = realpath($basePath . DIRECTORY_SEPARATOR . $availableSpecs[$resolvedSpec]);

    if (!$filePath || !is_file($filePath) || !str_starts_with($filePath, $basePath)) {
        abort(404);
    }

    return response()->file($filePath, [
        'Content-Type' => str_ends_with($filePath, '.yaml') ? 'application/yaml' : 'application/json',
    ]);
})->name('openapi.spec');

// route untuk proxy API requests ke CZLink API melalui server kita
Route::match(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], '/czlink-proxy/{path}', function (Request $request, $path) {
    if ($request->isMethod('options')) {
        return response('', 204);
    }

    $baseUrl = 'https://api-link.cashup.id';

    return ApiProxy::handle($request, $path, $baseUrl);
})->where('path', '.*')->name('api.proxy');

/// route untuk proxy API requests ke CDCP API melalui server kita
Route::match(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], '/cdcp-proxy/{path}', function (Request $request, $path) {
    if ($request->isMethod('options')) {
        return response('', 204);
    }

    $baseUrl = 'https://tucanos-miniatm.cashlez.com';

    return ApiProxy::handle($request, $path, $baseUrl);
})->where('path', '.*')->name('api.proxy.cdcp');

// route untuk proxy API requests ke QRIS API melalui server kita
Route::match(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], '/qris-proxy/{path}', function (Request $request, $path) {
    if ($request->isMethod('options')) {
        return response('', 204);
    }

    $baseUrl = 'https://tucanos-miniatm.cashlez.com';

    return ApiProxy::handle($request, $path, $baseUrl);
})->where('path', '.*')->name('api.proxy.qris');

// route untuk proxy API requests ke BNPL API melalui server kita
Route::match(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], '/bnpl-proxy/{path}', function (Request $request, $path) {
    if ($request->isMethod('options')) {
        return response('', 204);
    }

    $baseUrl = 'https://angelfish.cashlez.com';

    return ApiProxy::handle($request, $path, $baseUrl);
})->where('path', '.*')->name('api.proxy.bnpl');

// route untuk proxy API requests ke Mini ATM API melalui server kita
Route::match(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], '/mini-atm-proxy/{path}', function (Request $request, $path) {
    if ($request->isMethod('options')) {
        return response('', 204);
    }

    $baseUrl = 'https://tucanos-miniatm.cashlez.com';

    return ApiProxy::handle($request, $path, $baseUrl);
})->where('path', '.*')->name('api.proxy.mini-atm');
