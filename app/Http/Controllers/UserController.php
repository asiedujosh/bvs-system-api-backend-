<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\LoginUserRequest;
use App\Traits\HttpResponses;
use App\Enums\TokenAbility;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Hash;
use Carbon\Carbon;


class UserController extends Controller
{
    use HttpResponses;
    //
    public function index(){
        $user = User::all();
        return $this->success([
            'user' => $user
           ]);
    }

    public function store(Request $request){
       //$request->validated($request->all());

       $role = $request->position === "Administrator" ? true : false;

       $user = new User;
       $user->personnel_id = $request->personnel_id;
       $user->name = $request->name;
       $user->contact = $request->contact;
       $user->location = $request->location;
       $user->email = $request->email;
       $user->password = $request->password;
       $user->position = $request->position;
       $user->super_admin = $role;
       $res = $user->save();

       if($res){
        return $this->success([
            'user' => $user
           ]);
       }
    }

    public function login(LoginUserRequest $request){
        $request->validated($request->all());

        $credentials = $request->only('personnel_id', 'password');

        if(!Auth::attempt($credentials)){
            return $this->error('','Credentials do not match', 401);
        }

        $user = User::where('personnel_id', $request->personnel_id)->first();
        // Set the expiration time for the token (e.g., 1 hour from now)
        $expirationTime = Carbon::now()->addMinutes(5);
        $rt_expirationTime = Carbon::now()->addHours(168);

        $accessToken = $user->createToken('access_token', [TokenAbility::ACCESS_API->value], $expirationTime);
        $refreshToken = $user->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], $rt_expirationTime);

        return $this->success([
            'user'=>$user,
            'access_token' => $accessToken->plainTextToken,
            'refresh_token' => $refreshToken->plainTextToken,
        ]);
    }


    public function changePassword(Request $request){
        $credentials = $request->only('personnel_id', 'password');
        if(!Auth::attempt($credentials)){
            return $this->error('','Cannot change password', 401);
        } else {
            $formField = [
                'password' => $request->password,
            ];
    
            $res = User::where('personnel_id', $request->personnel_id)->update($formField);
            if($res){
                return $this->success([
                    'message' => "User Updated Successfully"
                ]);
            }
        }
    }


    public function staffProfile($id){
        $res = User::where('id', $id)->first();
        return $this->success([
            'staffProfile' => $res
        ]);
    }


    public function staffSearch(Request $request){
        $results = User::latest()->filter(request(['keyword']))->get();
        return $this->success([
            'user' => $results
        ]);
    }


    public function staffUpdate(Request $request, $id){
        $role = $request->position === "Administrator" ? true : false;
        $formField = [
            'name' => $request->name,
            'contact' => $request->contact,
            'location' => $request->location,
            'email' => $request->email,
            'position' => $request->position,
            'super_admin' => $role
        ];

        $res = User::where('id', $id)->update($formField);
        if($res){
            return $this->success([
                'message' => "User Updated Successfully"
            ]);
        }
    }

    public function staffDelete($id){
        $res = User::where('id', $id)->delete();
        return $this->success([
            'message' => "User deleted Successfully"
        ]);
    }


    public function getUserDetails(){
        $user = Auth::user(); // Retrieve the authenticated user
        return response()->json(['user' => $user]);
    }

    public function refreshToken(Request $request){
        $expirationTime = Carbon::now()->addHours(1);
        $rt_expirationTime = Carbon::now()->addHours(168);
        $accessToken = $request->user()->createToken('access_token', [TokenAbility::ACCESS_API->value], $expirationTime);
        $refreshToken = $request->user()->createToken('refresh_token', [TokenAbility::ISSUE_ACCESS_TOKEN->value], $rt_expirationTime);
        return ['access_token' => $accessToken->plainTextToken, 'refresh_token' => $refreshToken->plainTextToken];
    }
}
