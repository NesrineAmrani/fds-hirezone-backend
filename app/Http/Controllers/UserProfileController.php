<?php

namespace App\Http\Controllers;

use App\Transformers\UserTransformer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Tymon\JWTAuth\Exceptions\JWTException;

class UserProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            //check if the user is authenticated
            $user = auth()->user();
        }catch (JWTException $e) {
            throw $e;
        }

        return $this->response
            ->item($user, new UserTransformer)
            ->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'firstname' => 'required|string|min:3|max:30',
            'lastname' => 'required|string|min:3|max:30',
            'gender'  => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()]);
        }

        try {
            if( !$user = auth()->user()) {
                throw new NotFoundHttpException('User profile not found');
            }

            $user->userProfile()->updateOrCreate(['user_id' => $user->id], [
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'gender' => $request->gender,
                'active' => true,
            ]);

        }catch (JWTException $e) {
            throw $e;
        }

        $response = [
            'message' => 'User profile created (updated) successfully',
            'id' => $user->id,
        ];

        return response()->json($response, 201);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {

        try {
            if (!$user = auth()->user()) {
                throw new NotFoundHttpException('User profile not found');
            }

            //Update firstname or lastname

            if(!empty($request->firstname)) {
                $validator = Validator::make($request->all(), [
                    'firstname' => 'required|string|min:3|max:30',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()]);
                }

                $user->userProfile()->updateOrCreate(['user_id' => $user->id], [
                    'firstname' => $request->firstname,
                ]);
            }

            if (!empty($request->lastname)) {
                $validator = Validator::make($request->all(), [
                    'lastname' => 'required|string|min:3|max:30',
                ]);

                if ($validator->fails()) {
                    return response()->json(['errors' => $validator->errors()]);
                }

                $user->userProfile()->updateOrCreate(['user_id' => $user->id], [
                    'lastname' => $request->lastname,
                ]);
            } 

            
        } catch (JWTException $e) {
            throw $e;
        }

        $response = [
            'message' => 'User profile updated successfully',
            'id' => $user->id,
        ];

        return response()->json($response, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy()
    {
        try {
            $user = auth()->user();
            $user->delete();
            auth()->logout();
        } catch (JWTException $e) {
            throw $e;
        }

        $response = [
            'message' => 'User profile deleted successfully',
            'id' => $user->id,
        ];

        return response()->json($response, 200);
    }
}
