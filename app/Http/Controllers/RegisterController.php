<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function register()
    {
        return view('front.account.register');
    }

    public function processregistation(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:5|same:confirm_password',
            'confirm_password' => 'required'
        ], [
            'email.unique' => 'This email is already registered. Please login or use a different email.'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        session()->flash('success', 'Your Registration was Successful');

        return response()->json([
            'status' => true,
            'message' => 'Registration Successful'
        ]);
    }



    public function login()
    {
        return view('front.account.login');
    }

    public function authetication(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if ($validator->passes()) {
            if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                return redirect()->route('account.profile');
            } else {
                return redirect()->route('login')->with('error', 'Either Email/password is incorrect');
            }
        } else {
            return redirect()->route('login')
                ->withErrors($validator)
                ->withInput($request->only('email'));
        }
    }

    public function profile()
    {
        return view('front.account.profile');
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }
}
