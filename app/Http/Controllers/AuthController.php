<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }
    
    // Menangani proses login
    public function login(Request $request)
{
    // Validate input
    $validate = $request->validate([
        'email' => 'required|email|max:255',
        'password' => 'required|string|min:8',
    ],[
        'email.required' => 'Email Wajib Disin tlol',
        'password.required' => 'passwordnya juga su',
    ]);

    // Check login credentials
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        return redirect()->route('dashboard');
    }

    // If login fails
    return back()->withErrors(['email' => 'Invalid credentials']);
}

    public function showRegisterForm()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validate = $request->validate([
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'confirm_password' => 'required|string|min:8',
        ],[
            'email.required' => 'Email Wajib Disin tlol',
            'email.email' => 'email valid boss',
            'email.unique' => 'Email yang lain ngab',
            'phone.required' => 'nomor hp di isi',
            'password.required' => 'password wajib',
            'confirm_password.required' => 'passwordnya juga su',
        ]);

        // Membuat user baru
        $user = User::create($validate);

        // Login otomatis setelah registrasi
        Auth::login($user);

        // Redirect setelah registrasi
        return redirect()->route('home');
    }

}
