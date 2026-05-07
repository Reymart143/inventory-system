<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('profile.index', compact('user'));
    }

    public function updateProfile(Request $request)
    {
        \Log::info($request->file('image'));
        
        $request->validate([
            'name'      => 'required|string|max:255',
            'number'    => 'required|string|max:11',
            'address'   => 'required|string|max:255',
            'birthday'  => 'required|date',
            'gender'    => 'required|string|in:male,female,other',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif', 
        ]);

        $user = Auth::user();

        $fileName = $user->image;

        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }
    
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/images'), $imageName);
    
            $fileName = 'storage/images/' . $imageName;
        }

        $user->update([
            'name' => $request->input('name'),
            'number' => $request->input('number'),
            'address' => $request->input('address'),
            'birthday' => $request->input('birthday'),
            'gender' => $request->input('gender'),
            'image' => $fileName,
        ]);

        return redirect()->back()->with('success', 'Personal information updated successfully.');
    }

    public function updateAccount(Request $request)
    {
        $rules = [
            'email' => 'required|email|max:255',
            'username' => 'required|string|max:255',
        ];

        if ($request->old_password || $request->new_password) {
            $rules['old_password'] = 'required|string';
            $rules['new_password'] = 'required|string|min:8|confirmed';
        }

        $request->validate($rules);

        $user = Auth::user();

        if ($request->old_password && !Hash::check($request->old_password, $user->password)) {
            return redirect()->back()->withErrors(['old_password' => 'The provided password does not match our records.']);
        }

        $user->update([
            'email' => $request->email,
            'username' => $request->username,
        ]);

        if ($request->new_password) {
            $user->password = Hash::make($request->new_password);
            $user->save();
        }

        return redirect()->back()->with('success', 'Account information updated successfully.');
    }

    public function updateEmergencyContact(Request $request)
    {
        $request->validate([
            'contact_name' => 'required|string|max:255',
            'contact_number' => 'required|string|max:11',
            'relationship' => 'required|string|max:255',
        ]);

        $user = Auth::user();
        
        $user->update([
            'contact_name' => $request->contact_name,
            'contact_number' => $request->contact_number,
            'relationship' => $request->relationship,
        ]);

        return redirect()->back()->with('success', 'Emergency contact updated successfully.');
    }


    


}
