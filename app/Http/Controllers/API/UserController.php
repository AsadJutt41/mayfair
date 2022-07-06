<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Traits\ApiResponser;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Rules\Api\MatchOldPassword;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use ApiResponser;

    public function userProfile($id) {
        $message = User::find($id);
        if($message) {
            return $this->sendResponse($message,'user data');
        } else {
            return $this->sendError('Sorry user not fount', 401);
        }
    }

    public function changePassword(Request $request) {

        $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'user_id' => 'required'
        ]);

        $u_id = $request->user_id;
        User::find($u_id)->update(['password'=> Hash::make($request->new_password)]);
        $fname = Auth()->user()->firstname;
        $lname = Auth()->user()->lastname;
        $user['name'] = $fname .' '. $lname;
        $user['email'] = auth()->user()->email;

        return response()->json(['Status' => 'Success', 'message' => 'Password change successfully', 'user' => $user]);
        // dd('Password change successfully.');
    }

    public function updateProfile(Request $request) {
         //validate number
         $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'profile_photo_path'   => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()->all()]);
        }

        $user = User::where('id', '=', $request->user_id)
            ->first();
            if($user){
                if ($image = $request->file('profile_photo_path')) {
                    $image = $request->file('profile_photo_path');
                    $filename = $image->getClientOriginalName();
                    $image->move(public_path('assets/images/users'), $filename);
                    $user->profile_photo_path = $filename;
                    $user->update(['profile_photo_path' => $filename]);
                    return response()->json(['Status' => 'success', 'data' => 'Successfully updated the user account']);
                }
            } else {
                return response()->json(['Status' => 'error', 'data' => 'sorry the given record not found']);
            }
    }

    public function updateFCMToken(Request $request){
        $validator = Validator::make($request->all(), [
            'fcmToken' => 'required',
        ]);
        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }
        if ($validator) {

            $user = User::where('email',$request->email)->first();
            if ($user == null) {
                return $this->sendError('Sorry, this user is not found in our record');
            } else {
                if ($user){
                    User::where('email',$request->email)->update(['fcm_token'=> $request->fcmToken ]);
                }

                $data['FCMToken']="fcm token updated";
                return $this->sendResponse($data, 'FCM Token Updated Successfully ');
                    return response()->json(['Status' => 'Success', 'message' => 'FCM Token Updated Successfully ', 'user' => $user]);
            }
        }
    }
}
