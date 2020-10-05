<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingsController extends Controller {
    public function upload_pp(Request $request) {
        $request->validate([
            'image' => 'mimes:jpeg,jpg,png,gif|required|max:5048'
        ]);
        $image = Storage::disk('profile_images')->put('', $request->file('image'));
        if(!$image) {
            return response()->json([
                'message'   =>  'Error uploading the file !',
            ], 500);
        }

        $request->user()->update([
            'profile_image'       =>      $image,
        ]);
        $request->user()->save();

        return response()->json([
            'image'   =>  $image
        ]);
    }
}
