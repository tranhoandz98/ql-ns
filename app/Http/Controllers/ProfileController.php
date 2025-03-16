<?php

namespace App\Http\Controllers;

use App\Enums\User\GenderUserEnum;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
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
        $GenderUserEnum = GenderUserEnum::options();
        return view(
            'pages.profile.edit',
            compact('result', 'GenderUserEnum')
        );
    }



    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {

        DB::beginTransaction();
        try {
            $result = $request->user();

            $result->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,

                'bank_account' => $request->bank_account,
                'bank_branch' => $request->bank_branch,
                'bank' => $request->bank,
                'permanent_address' => $request->permanent_address,
                'current_address' => $request->current_address,
                'nation' => $request->nation,
                'nationality' => $request->nationality,
                'date_of_birth' => $request->date_of_birth,

                'place_of_issue' => $request->place_of_issue,
                'date_of_issue' => $request->date_of_issue,

                'start_date' => $request->start_date,
                'person_tax_code' => $request->person_tax_code,
                'identifier' => $request->identifier,
            ]);
            if (empty($request->avatar) && !$request->hasFile('fileAvatar')) {
                $result->update([
                    'avatar' => null,
                    'face_descriptor' => null,
                ]);
            }
            if ($request->hasFile('fileAvatar')) {
                if ($result->avatar) {
                    Storage::delete('public/' . $result->avatar);
                }

                $imagePath = $request->file('fileAvatar')->store('uploads', 'public');

                $result->update([
                    'avatar' => $imagePath,
                    'face_descriptor' => $request->face_descriptor,
                ]);
            }
            DB::commit();

            return Redirect::route('profile.edit')
                ->with(
                    ['message' => Lang::get('messages.user-update_s'), 'status' => 'success']
                );
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
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
