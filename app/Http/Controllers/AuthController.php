<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use  App\Models\User;

class AuthController extends Controller
{



    /**
     * Get a JWT via given credentials.
     *
     * @param  Request  $request
     * @return Response
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh', 'logout','createUser']]);
    }
    public function createUser(Request $request)
    {

        $this->validate($request, [
            'name' => 'required|string',
            'email' => 'required|string',
            'password' => 'required|string',
            'phoneNo' => 'required|integer',
            'cnic' => 'required|integer',
            'fatherName' => 'required|string',
            'address' => 'required|string',
            'bio' => 'required|string',
        ]);

        $credentials =new User;

        $credentials->name=$request->input("name");
        $credentials->email=$request->input("email");
        $credentials->password=Hash::make($request->input("password"));
        $credentials->phoneNo=$request->input("phoneNo");
        $credentials->cnic=$request->input("cnic");
        $credentials->fatherName=$request->input("fatherName");
        $credentials->address=$request->input("address");
        $credentials->bio=$request->input("bio");

        $credentials->save();
        return response()->json($credentials);
    }

    public function login(Request $request)
    {

        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);

        if (! $token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        // User::where('id', auth()->user()->id)->update(['remember_token' => $token]);
        return $this->respondWithToken($token);
    }

     /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me()
    {
        return response()->json(auth()->user());
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'user' => auth()->user(),
            'expires_in' => auth()->factory()->getTTL() * 60 * 24
        ]);
    }
}