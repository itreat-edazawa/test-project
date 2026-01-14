<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use App\Models\foods;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        $favorite_food_index = $request->user()->favorite_food;
        $favorite_food_tmp = foods::where('id',$favorite_food_index)->first();
        if(!empty($favorite_food_tmp)){
            $favorite_food = $favorite_food_tmp['foodname'];
        }
        else{
            $favorite_food = "設定なし";
        }
        
        return view('profile.edit', [
            'user' => $request->user(),
            'foods' => foods::pluck('foodname','id'),
            'favorite_food' => $favorite_food,
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
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }

    public function store(Request $request, User $user){

        $user = $request->user();

        $img=$request->file('profile_imagepath');

        $imgpath = $user->profile_imagepath;
        if(isset($img)){

            if(!empty($imgpath)){
                \Storage::disk('public')->delete($imgpath);
            }
            

            $imgpath = $img->store('profile_img', 'public');
            
        }

        $user->update([
            'profile_imagepath' => $imgpath,
        ]);

        return redirect()->route('profile.edit');
    }

    public function Getfavoritefood(Request $request){

        $user = $request->user();
        //indexなの注意
        $favfood = $request['favorite_food'];

        $user->update([
            'favorite_food' => $favfood,
        ]);

        return redirect()->route('profile.edit');

    }
}
