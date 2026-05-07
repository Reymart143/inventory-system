<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserSetting;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', [1, 2])
                    ->where('role', '!=', 0); 

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('email', 'LIKE', "%{$search}%")
                ->orWhere('address', 'LIKE', "%{$search}%")
                ->orWhere('username', 'LIKE', "%{$search}%")
                ->orWhere('number', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->get();

        return view('users.index', compact('users')); 
    }

    public function create()
    {
        return view('users.create'); 
    }
    public function saveSettings(Request $request)
    {
        $userId = auth()->id(); 
        $color  = $request->input('color');
        $type   = $request->input('type');

        $settings = UserSettings::updateOrCreate(
            ['user_id' => $userId],
            [
                'sidebar_color' => $color,
                'sidebar_type' => $type
            ]
        );

        return response()->json(['success' => true]);
    }

    public function getSettings()
    {
        $userId = auth()->id(); 
        $settings = UserSettings::where('user_id', $userId)->first();

        return response()->json([
            'sidebar_color' => $settings->sidebar_color ?? null,
            'sidebar_type'  => $settings->sidebar_type ?? null
        ]);
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'username'  => 'required|string|max:255|unique:users,username',
            'birthday'  => 'required|date', 
            'gender'    => 'required|string|in:male,female,other',
            'number'    => 'required|numeric',
            'address'   => 'required|string|max:255',
            'password'  => 'required|string|min:8|same:confirm_password',
            'role'      => 'required|integer|in:1,2',
            'image'     => 'required|image|mimes:jpeg,png,jpg,gif',
        ]);

        $validated['password'] = bcrypt($validated['password']);

        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/images'), $imageName);
            $validated['image'] = 'storage/images/' . $imageName; 
        }

        User::create($validated);

        return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user')); 
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user')); 
    }

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'birthday'  => 'required|date',
            'gender'    => 'required|string|in:male,female,other',
            'number'    => 'required|numeric',
            'address'   => 'required|string|max:255',
            'username'  => 'required|string|max:255|unique:users,username,' . $user->id,
            'password'  => 'nullable|string|min:8|confirmed', 
            'role'      => 'required|integer|in:1,2',
            'image'     => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', 
        ]);

        if ($request->filled('password')) {
            $validated['password'] = bcrypt($request->password);
        } else {
            unset($validated['password']); 
        }

        if ($request->hasFile('image')) {
            if ($user->image && file_exists(public_path($user->image))) {
                unlink(public_path($user->image));
            }

            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('storage/images'), $imageName);
            $validated['image'] = 'storage/images/' . $imageName;
        }

        $user->update($validated);

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    }


    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|integer|in:0,1',
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return redirect()->route('users.index')->with('success', 'User status updated successfully.');
    }

}
