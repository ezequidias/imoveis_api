<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{

    /**
     * @OA\Post(
     *      path="/api/register",
     *      operationId="RegisterUser",
     *      tags={"Auth"},
     *      summary="Create user",
     *      description="Create a new user",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreateUserRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error data fields"
     *       )
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function register(RegisterRequest $request)
    {
        $user_exists = User::where('email', $request->email)->first();
        if (isset($user_exists->id) && !empty($user_exists->id)) return response()->json(['message' => 'E-mail ja existe cadastrado'], 400);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json([
            'token' => $user->createToken('App')->plainTextToken,
            'user' => $user,
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/login",
     *      operationId="loginUser",
     *      tags={"Auth"},
     *      summary="Login user",
     *      description="Login a user",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/LoginUserRequest")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     *      @OA\Response(
     *          response=422,
     *          description="Error data fields"
     *       ),
     * )
     *
     * @return \Illuminate\Http\Response
     */
    
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only(['email', 'password']))) return response()->json([ 'message' => 'E-mail ou senha incorretos.'], 401);

        $user = Auth::user();

        return response()->json([
            'token' => $user->createToken('App')->plainTextToken,
            'user' => $user,
        ], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/user",
     *     operationId="getUserInfo",
     *      tags={"Auth"},
     *      summary="Get user information",
     *      description="Returns user information",
     *     @OA\Response(
     *          response="200",
     *          description="Get user information"
     *       )
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function user(Request $request)
    {
        return response()->json(new UserResource(auth()->user()), 200);
    }

    /**
     * @OA\Post(
     *     path="/api/logout",
     *     operationId="logoutUser",
     *      tags={"Auth"},
     *      summary="Logout user",
     *      description="Logout User",
     *     @OA\Response(
     *          response="200",
     *          description="Logout User"
     *       )
     * )
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json( ['message' => 'Sucesso'], 200);
    }

}
