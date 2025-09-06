<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Elegant\Sanitizer\Sanitizer;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:100',
            'username' => 'required|string|max:50|unique:users,username',
            'email'    => 'required|email|unique:users,email',
            'password' => 'required|string|min:6',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $filters = [
            'name'     => 'trim|escape|capitalize',
            'username' => 'trim|escape|lowercase',
            'email'    => 'trim|escape|lowercase',
            'password' => 'trim|escape',
        ];

        $sanitizer = new Sanitizer($request->all(), $filters);
        $attrclean = $sanitizer->sanitize();

        $attrclean['password'] = Hash::make($attrclean['password']);

        $user = User::create([
            'name'     => $attrclean['name'],
            'username' => $attrclean['username'],
            'email'    => $attrclean['email'],
            'password' => $attrclean['password'],
        ]);

        $user->assignRole('Student');

        return redirect()->route('login')->with('success', 'Registrasi berhasil, silakan login.');
    }
}
