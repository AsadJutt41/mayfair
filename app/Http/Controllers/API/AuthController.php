<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AuthController extends Controller
{
    use ApiResponser;
    public function login(Request $request) {
        $attr = $request->validate([
            'email' => 'required',
            'password' => 'required'
        ]);

        if (!Auth::attempt($attr)) {
            return $this->sendError('Credentials not match', 201);
        } else {
            $message['token'] = 'Bearer ' .  auth()->user()->createToken('API Token')->plainTextToken;
            $message['user_id'] = Auth()->user()->id;
            $fname = Auth()->user()->firstname;
            $lname = Auth()->user()->lastname;
            $message['name'] = $fname .' '. $lname;
            $message['email'] = Auth()->user()->email;
            $pro_image = Auth()->user()->profile_photo_path;

            $message['image'] =  asset('assets/images/users/' . $pro_image);
            return $this->sendResponse($message,'user successfully login');
        }
    }

    public function logout()
    {
        $auth = Auth()->user();
        $user = auth()->user()->tokens()->delete();
        return $this->sendResponse($auth,'user logout successfully');
    }

}
