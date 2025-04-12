<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdatePasswordRequest;
use App\Http\Requests\UpdateProfilePhotoRequest;
use App\Http\Requests\UpdateProfileEmployeeRequest;

class ProfileController extends Controller
{
    public function show()
    {
        return view('clients.profile');
    }

    public function update(UpdateProfileRequest $request)
    {
        $user = auth()->user();
        
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        if ($request->new_password) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    public function updatePhoto(UpdateProfilePhotoRequest $request)
    {
        $path = $request->file('profile_photo')->store('profile-photos', 'public');
        
        if (auth()->user()->photo) {
            Storage::disk('public')->delete(auth()->user()->photo);
        }
        
        auth()->user()->update(['photo' => $path]);

        return back()->with('success', 'Photo de profil mise à jour');
    }

    public function edit()
    {
        return view('admin.profile');
    }

    public function updateEmployee(UpdateProfileEmployeeRequest $request)
    {
        $user = auth()->user();
        $data = $request->validated();

        if ($request->hasFile('photo')) {

            if ($user->photo) {
                Storage::delete('public/'.$user->photo);
            }

            $data['photo'] = $request->file('photo')->store('profile-photos', 'public');
        }

        $user->update($data);

        return back()->with('success', 'Profil mis à jour avec succès');
    }

    public function updatePassword(UpdatePasswordRequest $request)
    {
        auth()->user()->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Mot de passe mis à jour avec succès');
    }
}
