<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Models\Person;
use Illuminate\Support\Facades\Auth; //


class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('/');
        }

        return back()->withErrors([
            'email' => 'Thông tin bạn nhập không khớp với hồ sơ',
        ]);
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $person = Person::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
        ]);

        Auth::login($person);

        return redirect('/');
    }

    public function __construct()
    {
        $this->middleware('auth');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
    public function showUserProfile()
{
    $user = Auth::user();

    // Truy cập các thông tin của người dùng
    $userId = $user->id;
    $userName = $user->name;
    $userEmail = $user->email;

    return view('user.profile', compact('user'));
}
}