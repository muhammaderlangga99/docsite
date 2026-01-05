<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CarlaController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('erica.carla', [
            'user' => $request->user(),
            'password' => '123456',
            'baudrate' => '9600',
        ]);
    }
}
