<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginValidation;
use App\Http\Requests\UserValidation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(LoginValidation $validate_login)
    {
        $data= $validate_login->validated();

        if(Auth::attempt($data)){
            $user = Auth::user();
            
            $is_password_weak = false;

            # check if password is weak
            if (strlen($data['password']) < 12 || !preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&_]+$/', $data['password'])) {
                $is_password_weak = true;
            }
            $success =  $user->createToken('MyApp')->plainTextToken;
            $role = $user->role;

            return response()->json(compact('success', 'user','role','is_password_weak'));
        }
        else{
            return response()->json(['error'=>'Invalid login credentials.'], 401);
        }
    }

    public function logout(Request $request)
    {
        $user = Auth::user();

        if ($user) {
            // Revoke only the current token
            $request->user()->currentAccessToken()->delete();
        }

        return response()->json(['message' => 'Logged out successfully.']);
    }


    public function register(Request $request, UserValidation $validate_user)
    {
        //
        $user_data = $validate_user->validated();

        $user_data['password'] =  bcrypt($user_data['password']);
        $user_data['role_id'] =  3;
        $user = User::create($user_data);

        return response()->json(compact('user'));
    }
}
