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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

        Route::get('/erica', [EricaController::class, 'index'])->name('erica.index');
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

Route::get('/api-playground/{spec?}', function ($spec = 'api-docs') {
    $availableSpecs = [
        'api-docs' => 'api-docs.yaml',
        'czlink-api' => 'czlink/api-docs.yaml',
        'api-cdcp' => 'api-cdcp.yaml',
        'cdcp-api' => 'api-cdcp.yaml',
    ];

    if (!array_key_exists($spec, $availableSpecs)) {
        abort(404);
    }

    return view('docs.api-playground', [
        'specPath' => '/openapi/' . $spec,
    ]);
})->name('docs.api-playground');

Route::get('/openapi/{spec}', function ($spec) {
    $availableSpecs = [
        'api-docs' => 'api-docs.yaml',
        'czlink-api' => 'czlink/api-docs.yaml',
        'api-cdcp' => 'api-cdcp.yaml',
        'cdcp-api' => 'api-cdcp.yaml',
    ];

    if (!array_key_exists($spec, $availableSpecs)) {
        abort(404);
    }

    $basePath = public_path('openapi');
    $filePath = realpath($basePath . DIRECTORY_SEPARATOR . $availableSpecs[$spec]);

    if (!$filePath || !is_file($filePath) || !str_starts_with($filePath, $basePath)) {
        abort(404);
    }

    return response()->file($filePath, [
        'Content-Type' => str_ends_with($filePath, '.yaml') ? 'application/yaml' : 'application/json',
    ]);
})->name('openapi.spec');

Route::match(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], '/api-proxy/{path}', function (Request $request, $path) {
    if ($request->isMethod('options')) {
        return response('', 204);
    }

    $allowedPrefixes = [
        'MmCoreCzLinkHost/',
        'MmCorePsgsHost/',
    ];

    $normalizedPath = ltrim($path, '/');
    $pathInfo = $request->getPathInfo();
    if (str_ends_with($pathInfo, '/') && !str_ends_with($normalizedPath, '/')) {
        $normalizedPath .= '/';
    }
    $isAllowed = false;
    foreach ($allowedPrefixes as $prefix) {
        if (str_starts_with($normalizedPath, $prefix)) {
            $isAllowed = true;
            break;
        }
    }

    if (!$isAllowed) {
        abort(404);
    }

    $baseUrl = 'https://api-link.cashup.id';
    $targetUrl = rtrim($baseUrl, '/') . '/' . $normalizedPath;
    $query = http_build_query($request->query());
    $finalUrl = $query ? $targetUrl . '?' . $query : $targetUrl;

    $excludedHeaders = [
        'host',
        'connection',
        'content-length',
        'accept-encoding',
        'origin',
        'referer',
        'cookie',
    ];

    $forwardHeaders = [];
    foreach ($request->headers->all() as $key => $values) {
        if (in_array(strtolower($key), $excludedHeaders, true)) {
            continue;
        }
        $forwardHeaders[$key] = implode(', ', $values);
    }

    $curl = curl_init($finalUrl);
    if ($curl === false) {
        abort(500, 'Failed to initialize proxy request.');
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->method());
    curl_setopt($curl, CURLOPT_HTTPHEADER, array_map(
        fn ($key, $value) => $key . ': ' . $value,
        array_keys($forwardHeaders),
        $forwardHeaders
    ));

    $body = $request->getContent();
    if ($body !== '') {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    }

    $rawResponse = curl_exec($curl);
    if ($rawResponse === false) {
        $error = curl_error($curl);
        curl_close($curl);
        abort(502, $error ?: 'Proxy request failed.');
    }

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    curl_close($curl);

    $rawHeaders = substr($rawResponse, 0, $headerSize);
    $responseBody = substr($rawResponse, $headerSize);

    $responseHeaders = [];
    foreach (preg_split('/\r\n|\r|\n/', trim($rawHeaders)) as $headerLine) {
        if (stripos($headerLine, 'HTTP/') === 0) {
            continue;
        }
        $parts = explode(':', $headerLine, 2);
        if (count($parts) !== 2) {
            continue;
        }
        $key = trim($parts[0]);
        $value = trim($parts[1]);
        if (in_array(strtolower($key), ['transfer-encoding', 'connection'], true)) {
            continue;
        }
        $responseHeaders[$key] = $value;
    }

    return response($responseBody, $status)->withHeaders($responseHeaders);
})->where('path', '.*')->name('api.proxy');

Route::match(['GET', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'], '/api-proxy-cdcp/{path}', function (Request $request, $path) {
    if ($request->isMethod('options')) {
        return response('', 204);
    }

    $allowedPrefixes = [
        'MmCoreCzLinkHost/',
        'MmCorePsgsHost/',
    ];

    $normalizedPath = ltrim($path, '/');
    $pathInfo = $request->getPathInfo();
    if (str_ends_with($pathInfo, '/') && !str_ends_with($normalizedPath, '/')) {
        $normalizedPath .= '/';
    }
    $isAllowed = false;
    foreach ($allowedPrefixes as $prefix) {
        if (str_starts_with($normalizedPath, $prefix)) {
            $isAllowed = true;
            break;
        }
    }

    if (!$isAllowed) {
        abort(404);
    }

    $baseUrl = 'https://tucanos-miniatm.cashlez.com';
    $targetUrl = rtrim($baseUrl, '/') . '/' . $normalizedPath;
    $query = http_build_query($request->query());
    $finalUrl = $query ? $targetUrl . '?' . $query : $targetUrl;

    $excludedHeaders = [
        'host',
        'connection',
        'content-length',
        'accept-encoding',
        'origin',
        'referer',
        'cookie',
    ];

    $forwardHeaders = [];
    foreach ($request->headers->all() as $key => $values) {
        if (in_array(strtolower($key), $excludedHeaders, true)) {
            continue;
        }
        $forwardHeaders[$key] = implode(', ', $values);
    }

    $curl = curl_init($finalUrl);
    if ($curl === false) {
        abort(500, 'Failed to initialize proxy request.');
    }

    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($curl, CURLOPT_HEADER, true);
    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $request->method());
    curl_setopt($curl, CURLOPT_HTTPHEADER, array_map(
        fn ($key, $value) => $key . ': ' . $value,
        array_keys($forwardHeaders),
        $forwardHeaders
    ));

    $body = $request->getContent();
    if ($body !== '') {
        curl_setopt($curl, CURLOPT_POSTFIELDS, $body);
    }

    $rawResponse = curl_exec($curl);
    if ($rawResponse === false) {
        $error = curl_error($curl);
        curl_close($curl);
        abort(502, $error ?: 'Proxy request failed.');
    }

    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    $headerSize = curl_getinfo($curl, CURLINFO_HEADER_SIZE);
    curl_close($curl);

    $rawHeaders = substr($rawResponse, 0, $headerSize);
    $responseBody = substr($rawResponse, $headerSize);

    $responseHeaders = [];
    foreach (preg_split('/\r\n|\r|\n/', trim($rawHeaders)) as $headerLine) {
        if (stripos($headerLine, 'HTTP/') === 0) {
            continue;
        }
        $parts = explode(':', $headerLine, 2);
        if (count($parts) !== 2) {
            continue;
        }
        $key = trim($parts[0]);
        $value = trim($parts[1]);
        if (in_array(strtolower($key), ['transfer-encoding', 'connection'], true)) {
            continue;
        }
        $responseHeaders[$key] = $value;
    }

    return response($responseBody, $status)->withHeaders($responseHeaders);
})->where('path', '.*')->name('api.proxy.cdcp');

Route::options('/openapi-proxy/{path}', function () {
    return response('', 204, [
        'Access-Control-Allow-Origin' => 'https://client.scalar.com',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => 'Origin, Content-Type, Accept, Authorization, Access-Control-Request-Private-Network',
        'Access-Control-Allow-Private-Network' => 'true',
        'Vary' => 'Origin',
        'Access-Control-Max-Age' => '86400',
    ]);
})->where('path', '.*');

Route::get('/openapi-proxy/{path}', function ($path) {
    $basePath = public_path('openapi');
    $filePath = realpath($basePath . DIRECTORY_SEPARATOR . $path);

    if (!$filePath || !is_file($filePath) || !str_starts_with($filePath, $basePath)) {
        abort(404);
    }

    return response()->file($filePath, [
        'Access-Control-Allow-Origin' => 'https://client.scalar.com',
        'Access-Control-Allow-Methods' => 'GET, OPTIONS',
        'Access-Control-Allow-Headers' => 'Origin, Content-Type, Accept, Authorization, Access-Control-Request-Private-Network',
        'Access-Control-Allow-Private-Network' => 'true',
        'Vary' => 'Origin',
        'Access-Control-Max-Age' => '86400',
    ]);
})->where('path', '.*');
