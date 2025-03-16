<?php

namespace App\Http\Controllers;

use App\Enums\User\GenderUser;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $result = $request->user();
        $genderUser = GenderUser::options();
        return view(
            'pages.profile.edit',
            compact('result', 'genderUser')
        );
    }



    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        $result = $request->user();
        if (empty($request->avatar) && !$request->hasFile('fileAvatar')) {
            $result->update([
                'avatar'=> null,
                'face_descriptor'=> null,
            ]);
        }
        if ($request->hasFile('fileAvatar')) {
            if ($result->avatar) {
                Storage::delete('public/' . $result->avatar);
            }

            $imagePath = $request->file('fileAvatar')->store('uploads', 'public');

            $result->update([
                'avatar'=> $imagePath,
                'face_descriptor'=> $request->face_descriptor,
            ]);
        }

        return Redirect::route('profile.edit')
        ->with(
            ['message' => Lang::get('messages.user-update_s'), 'status' => 'success']
        );
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
