<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class App2AppMiniAtmController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('app2app.mini-atm', [
            'user' => $request->user(),
            'host' => 'https://tucanos-miniatm.cashlez.com/',
            'password' => '123456',
        ]);
    }
}
