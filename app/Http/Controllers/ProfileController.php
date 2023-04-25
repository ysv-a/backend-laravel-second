<?php

namespace App\Http\Controllers;

use App\Models\User;
use ReflectionClass;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Services\Sms\SmsSender;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Redirect;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Support\Facades\Storage;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProfileController extends Controller
{
    // public function __construct(
    //     public \Illuminate\Contracts\Auth\Factory $auth
    // ){}
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $documents = $request->user()->getMedia('documents');

        return view('profile.edit', [
            'user' => $request->user(),
            'documents' => $documents,
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current-password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function addDcouments(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|file',
        ]);

        $file = $request->file('file');

        auth()->user()->addMedia($file)->toMediaCollection('documents', 'local');

        return Redirect::to('/profile');
    }


    public function getDcouments(string $uuid)
    {
        $media = Media::where('uuid', $uuid)->first();
        return response()->download($media->getPath(), $media->file_name);
    }

}
