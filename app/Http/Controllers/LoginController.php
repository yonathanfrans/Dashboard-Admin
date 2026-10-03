<?php

namespace App\Http\Controllers;

use App\Helpers\ActivityLogger;
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

                $userData = $response['response_data'];

                session([
                    'login_token' => $userData,
                    'username' => $credentials['username'],
                    'nama_user' => $userData['nama_user'],
                    'email' => $credentials['username']
                ]);

                // Catat log login
                ActivityLogger::log('Login ke dashboard');

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
        // Catat log logout
        ActivityLogger::log('Logout dari dashboard');

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}
