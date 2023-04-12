<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Hash, Auth;



class ProfileController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        return view('backend.settings.profile', compact('user'));
    }


    public function changeInfo(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'photo' =>  'mimes:jpeg,png,jpg|max:2048',
            'name' =>   'required|string|min:4',
            'email' =>  'required|unique:users,email,' . $user->id,
        ]);


        if ($request->has('photo')) {
            $file = $request->photo;
            $user->avater = FileUpload($file, "uploads/" , $user->avater);
        }


        $user->update([
            $user->name = $request->name,
            $user->email = $request->email,
            $user->avater = $user->avater
        ]);



        return back()->with('success', 'Profile successfully changed!');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->with('error', 'Current password does not match!');
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Password successfully changed!');
    }
}
