<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;


class UserController extends Controller
{

    private $perPage = 1;

    /**
     * @OA\Get(
     *     path="/api/users",
     *     operationId="getUsersList",
     *      tags={"Users"},
     *      summary="Get list of Users",
     *      description="Returns list of Users",
     *     @OA\Response(
     *          response="200",
     *          description="Get all Users"
     *       )
     * )
     */
    public function index(Request $request)
    {
        $data = new User;
        $search = $request->filter_search;
        $sortKey = $request->sortKey;
        $sortOrder = $request->sortOrder;

        if (isset($sortKey) && !empty($sortKey) && isset($sortOrder) && !empty($sortOrder)) {
            $data = (strtolower($sortOrder) == 'desc') ? $data->orderBy($sortKey, 'DESC') : $data->orderBy($sortKey, 'ASC');
        } else {
            $data = $data->orderBy('id', 'ASC');
        }

        if (isset($search) && !empty($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('name', 'like', '%' . $search . '%')->orWhere('email', 'like', '%' . $search . '%');
            });
        }

        $data = $data->paginate($this->perPage);

        return response()->json([
            'data' => [
                'users' => new UserCollection($data)
            ]
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/users",
     *      operationId="createUser",
     *      tags={"Users"},
     *      summary="Create user",
     *      description="Create a new user with the specified details.<br>type(ENUM) = 'house, apartment, land' <br> status (ENUM) = 'available, rented, sold'",
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/CreatePropertyRequest")
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
     */
    public function store(RegisterRequest $request)
    {
        $user_exists = User::where('email',$request->email)->first();
        if (isset($user_exists->id) && !empty($user_exists->id)) return response()->json(['message' => 'E-mail ja existe cadastrado'], 400);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
        ]);

        return response()->json(['data' => new UserResource($user), 'message' => __('global.Save succesfully.')], 200);
    }

    /**
     * @OA\Put(
     *      path="/api/users/{id}",
     *      operationId="updateUser",
     *      tags={"Users"},
     *      summary="Update existing user",
     *      description="Returns updated user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/UpdatePropertyRequest")
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
     */
    public function update(RegisterRequest $request, $id)
    {
        $user = User::find($id);
        if (!isset($user->id) || empty($user->id)) return response()->json(['message' => 'Usuário não foi encontrado'], 400);

        $user_exists = User::where('email', $request->email)->whereNot('id',$id)->first();
        if (isset($user_exists->id) && !empty($user_exists->id)) return response()->json(['message' => 'E-mail ja existe cadastrado'], 400);

        $user->update([
            'name' => $request->name,
            'email' => $request->email
        ]);

        return response()->json(['data' => new UserResource($user), 'message' => __('global.Save succesfully.')], 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/users/{id}",
     *      operationId="deleteUser",
     *      tags={"Users"},
     *      summary="Delete existing user",
     *      description="Deletes a record",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      ),
     * )
     */
    public function destroy(Request $request, $id)
    {
        $user = User::find($id);
        if (!isset($user->id) || empty($user->id)) return response()->json(['message' => 'Usuário não foi encontrado'], 400);
        $user->delete();
        return response()->json(['message' => 'Deletado com sucesso'], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/users/{id}",
     *     operationId="getUsersById",
     *      tags={"Users"},
     *      summary="Get user information",
     *      description="Returns user data",
     *      @OA\Parameter(
     *          name="id",
     *          description="User id",
     *          required=true,
     *          in="path",
     *          @OA\Schema(
     *              type="integer"
     *          )
     *      ),
     *     @OA\Response(
     *          response="200",
     *          description="Successful operation"
     *       ),
     *      @OA\Response(
     *          response=400,
     *          description="Bad Request"
     *      )
     * )
     */
    public function show(Request $request, $id)
    {
        $user = User::find($id);
        if (!isset($user->id) || empty($user->id)) return response()->json(['message' => 'Usuário não foi encontrado'], 400);
        return response()->json( ['data' => new UserResource($user)], 200);
    }
}
