<?php

namespace DevForIslam\QuranApi\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class ApiLoginController extends Controller
{
    //

    use AuthenticatesUsers;

    public function __construct()
    {
        request()->headers->set('Accept', 'application/json');      
    }
    
    /**
     * Override the response to send after the user was authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    protected function sendLoginResponse(Request $request)
    {
        $this->clearLoginAttempts($request);
        $user = \Auth::user();
        $token = $user->createToken('Personal Access Token')->accessToken;
        
        return response()->json(['access_token' => $token, 'user' => $user]);
    }

    public function register(Request $request)
    {
        $this->validateRegister($request);
        
        $user = \App\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        $token = $user->createToken('Personal Token')->accessToken;
        
        return response()->json(['access_token' => $token, 'user' => $user]);
    } 

     /**
     * Validate the user registration request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateRegister(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);
    }
}
