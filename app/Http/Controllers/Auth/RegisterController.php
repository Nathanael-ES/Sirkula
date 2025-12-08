<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function show()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->only(['name','email','phone']);
        $data['password'] = Hash::make($request->password);
        $data['role'] = $request->filled('role') ? $request->role : 'donatur';

        $user = User::create($data);

        Auth::login($user);

        return redirect()->route('dashboard')->with('success', __('messages.register_success'));
    }
}
