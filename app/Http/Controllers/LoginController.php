<?php

namespace App\Http\Controllers;

use App\Services\LoginApiService;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function authenticate(Request $request, LoginApiService $loginApiService)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required'
        ]);

        try {
            $response = $loginApiService->login(
                $credentials['username'],
                $credentials['password']
            );

            // dd($response);

            if (isset($response['status']) && $response['status'] === 200 && !empty($response['response_data'])) {
                $request->session()->regenerate();

                session([
                    'login_token' => $response['response_data'],
                    'username' => $credentials['username'],
                ]);

                return redirect()->intended('dashboard');
            }

            return back()->withErrors(['login' => 'Username atau password salah.'])->onlyInput('username');
            
        } catch (\Throwable $e) {
            // dd($e->getMessage());
            return back()->withErrors(['login' => 'Terjadi kesalahan saat menghubungi server'])->onlyInput('username');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
