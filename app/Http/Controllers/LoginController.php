<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\ActivityLog;
use Carbon\Carbon;


class LoginController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::check()) {
            return redirect()->intended(route('dashboard')); 
        }
        $request->validate([
            'login' => 'required|string',
            'password' => 'required|string',
        ]);

        $loginType = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginType => $request->login,
            'password' => $request->password,
        ];

        if (Auth::attempt($credentials, $request->remember)) {
            if (Auth::user()->status == 1) {
                Auth::logout();
                return back()->withErrors([
                    'login' => 'Your account is inactive. Please contact admin for reactivation.',
                ])->withInput($request->only('login', 'remember'));
            }
            
            $user = Auth::user();
            
            if ($user->role == 0) {
                return redirect()->intended(route('dashboard')); 
            } elseif ($user->role == 1) {
                $this->authenticated($request, Auth::user());
                return redirect()->intended(route('stock-in-products')); 
            } elseif ($user->role == 2) {
                $this->authenticated($request, Auth::user());
                return redirect()->intended(route('customer-orders')); 
            } elseif ($user->role == 3) {
                $this->authenticated($request, Auth::user());
                return redirect()->intended(route('customer-transactions')); 
            }
    
            return redirect()->intended(route('dashboard')); 
        }

        return back()->withErrors([
            'login' => 'The provided credentials do not match our records.',
        ])->withInput($request->only('login', 'remember'));
    }

    public function logout(Request $request)
    {
        $log = ActivityLog::where('user_id', Auth::id())
                ->whereNull('logout_time')
                ->latest()
                ->first();

        if ($log) {
            $log->logout_time = Carbon::now();
            $log->save();
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

   protected function authenticated(Request $request, $user)
    {
    
        \Log::info('Authenticated method called for user: ' . $user->id);

        
        ActivityLog::create([
            'user_id' => $user->id,
            'login_time' => Carbon::now('Asia/Manila'),
        ]);
    }


}
