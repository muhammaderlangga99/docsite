<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Host2HostCnpController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('host2host.cnp', [
            'user' => $request->user(),
            'host' => 'https://tucanos-dev.cashlez.com/',
            'password' => '123456',
        ]);
    }
}
