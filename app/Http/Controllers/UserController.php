<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Session;

session_start();

class UserController extends Controller
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
            $user = Auth::user();
            $name = $user->name;
            $phone = $user->phone;
            $address = $user->address;
            Session::put('name', $name);
            Session::put('phone', $phone);
            Session::put('address', $address);
            return Redirect::to('/');
        }

        return back()->withErrors([
            'email' => 'Thông tin bạn nhập không khớp với hồ sơ',
        ]);
    }
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    public function save_register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:5',
            'phone' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'created_at' => now(),
            'updated_at' => now(),

        ]);

        if ($validator->fails()) {
            return redirect('/register')
                ->withErrors($validator)
                ->withInput();
        }

        // Validation passed, create the user
        $person = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'phone' => $request->input('phone'),
            'address' => $request->input('address'),
        ]);

        if ($person->password = $request->input('confirm_password')) {
            Auth::login($person);
        }
        // Log in the user after successful registration

        // Redirect to home page
        return redirect('login');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
        Auth::logout();

        return redirect('/');
    }
}
