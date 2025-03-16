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
        $request->user()->fill($request->validated());

        if ($request->hasFile('fileAvatar')) {
            if ($request->user()->avatar) {
                Storage::delete('public/' . $request->user()->avatar);
            }

            $imagePath = $request->file('fileAvatar')->store('uploads', 'public');
            // $url = Storage::url($imagePath);
            $request->user()->avatar = $imagePath;
            $request->user()->face_descriptor = ($request->face_descriptor);
        }

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

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
