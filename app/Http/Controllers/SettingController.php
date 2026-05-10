<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class SettingController extends Controller
{
    // SETTINGS PAGE
    public function index()
    {
        $settings = Setting::first();

        // all users (admin panel)
        $users = User::orderBy('id', 'desc')->where('role',1)->get();

        return view('admin.settings', compact('settings', 'users'));
    }

    // UPDATE SETTINGS
    public function update(Request $request)
    {
        $request->validate([
            'site_name' => 'nullable|string|max:255',
            'game_win_mode' => 'nullable',
            'game_time_mode' => 'nullable',
        ]);

        $settings = Setting::first() ?? new Setting();

        $settings->site_name = $request->site_name;
        $settings->game_win_mode = $request->game_win_mode;
        $settings->game_time_mode = $request->game_time_mode;

        $settings->save();

        return back()->with('success', 'Settings updated successfully');
    }

    // UPDATE USER
    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'username' => 'nullable|string|max:255',
            'name'     => 'nullable|string|max:255',
            'phone'    => 'nullable|string|max:20',
            'email'    => 'nullable|email|max:255',
            'wallet'   => 'nullable|numeric',
            'password' => 'nullable|min:6',
        ]);

        $user = User::findOrFail($id);

        $user->username = $request->username;
        $user->name     = $request->name;
        $user->phone    = $request->phone;
        $user->email    = $request->email;

        // wallet update
        if ($request->has('wallet')) {
            $user->wallet = $request->wallet;
        }

        // password only if filled
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return back()->with('success', 'User updated successfully');
    }
}