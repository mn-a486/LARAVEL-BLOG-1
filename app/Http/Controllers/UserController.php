<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $user;
    const LOCAL_STORAGE_FOLDER = 'avatars/';

    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    public function show()
    {
        return view('users.show')->with('user', Auth::user());
    }

    public function see($user_id)
    {
        $user = $this->user->findOrFail($user_id);

        return view('users.show')->with('user', $user);
    }

    public function edit()
    {
        return view('users.edit')->with('user', Auth::user());
    }

    public function update(Request $request)
    {
        $request->validate([
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:1048',
            'name' => 'required|max:50',
            'email' => 'required|email|max:50|unique:users,email,' . Auth::id(),
            'password' => 'nullable|string|min:8|confirmed'
        ]);

        $user = $this->user->findOrFail(Auth::id());
        $user->name = $request->name;
        $user->email = $request->email;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar) {
                $this->deleteAvatar($user->avatar);
            }
            $user->avatar = $this->saveAvatar($request->avatar);
        }

            $user->save();

            return redirect()->route('profile.edit')->with('success', 'Profile updated successfully!');
    }

    private function saveAvatar($avatar)
    {
        $avatar_name = time() . "." . $avatar->extension();
        $avatar->storeAs(self::LOCAL_STORAGE_FOLDER, $avatar_name);

        return $avatar_name;
    }

    private function deleteAvatar($avatar)
    {
        $avatar_path = self::LOCAL_STORAGE_FOLDER . $avatar;

        if(Storage::disk('public')->exists($avatar_path)){
            Storage::disk('public')->delete($avatar_path);
        }
    }
}
