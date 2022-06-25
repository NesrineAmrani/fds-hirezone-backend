<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rules\Password;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

class AuthController extends Controller
{
    public function login(Request $request)
    {

        $rules = [
            'email' => [
                'required','email','max:255',
            ],
            'password' => [
                'required','string',
                Password::min(8)
                    //->mixedCase()
                    //->numbers()
                    //->symbols()
                    //->uncompromised()
            ],
        ];

        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()) {
            return response()->json([
                'validation_errors' => $validator->errors(),
            ], 401) ;
            
        }

        $credentials = $request->only('email', 'password');

        try {
            if( !$token = auth()->attempt($credentials))
                //throw new UnauthorizedHttpException('Wrong Email or Password');
                return response()->json(['error' => 'Wrong Email or Password'], 401);

        } catch (JWTException $e) {
            throw $e;
            //return response()->json(['error' => 'Could not create Token']);
        }

        return $this->respondWithToken($token);
}

    public function refresh() 
    {
        try {
            if( !$token = auth()->getToken()) {
                throw new NotFoundHttpException('Token does not exist');
            }
            
            return $this->respondWithToken(auth()->refresh($token));

        }catch ( JWTException $e ){
            throw $e;
        }

    }

    public function logout()
    {
        try {
            auth()->logout();

        }catch (JWTException $e){
            throw $e;
        }

        return response()->json([
            'message' => 'User Logged Out',
        ]);

        
    }

    private function respondWithToken($token){
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'user' => auth()->user(),
            //'status' => 200,
        ]);
    }

}
