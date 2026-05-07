<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class RegisterController extends Controller
{
    public function index(){
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'username'          => 'required|string|max:255|unique:users',
            'name'              => 'required|string|max:255',
            'email'             => 'required|string|email|max:255|unique:users',
            'number'            => ['required', 'string', 'regex:/^(09|\+63)\d{9}$/', 'max:11', 'unique:users,number'],
            'password'          => 'required|string|min:8|same:confirm_password',
            'address'           => 'required|string|max:255',
            'gender'            => 'required|in:male,female',
            'birthday'          => 'required|date|before:-20 years',
            'image'             => 'nullable',
        ]);

        $fileName = 'img/default/profile.jpg'; 

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('storage/images'), $imageName);
            $fileName = 'storage/images/' . $imageName; 
        }

        $user = User::create([
            'username'          => $validatedData['username'],
            'name'              => $validatedData['name'],
            'email'             => $validatedData['email'],
            'number'            => $validatedData['number'],
            'password'          => Hash::make($validatedData['password']),
            'address'           => $validatedData['address'],
            'gender'            => $validatedData['gender'],
            'birthday'          => $validatedData['birthday'],
            'image'             => $fileName,
            'role'              => 3,
        ]);

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }

}
