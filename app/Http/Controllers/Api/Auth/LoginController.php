<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ]);

        $request->request->add([
            'grant_type' => 'password',
            'client_id' => 2,
            'client_secret' => 'GoiImZVf9daBf9grZRR7l72Gtp7661KXNvgOy8Ik',
            'username' => $request->username,
            'password' => $request->password
        ]);

        $tokenRequest = Request::create(env('APP_URL') .'/oauth/token', 'post');
        $response = Route::dispatch($tokenRequest);
        return $response;
    }

    public function destroy(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(null, 204);
    }
}
