<?php

namespace App\Http\Controllers;

use App\Http\Requests\PropertyRequest;
use App\Http\Resources\PropertiesCollection;
use App\Http\Resources\PropertiesResource;
use App\Models\Property;
use Illuminate\Http\Request;


class PropertyController extends Controller
{

    private $perPage = 1;

    /**
     * @OA\Get(
     *     path="/api/properties",
     *     operationId="getPropertiesList",
     *      tags={"Properties"},
     *      summary="Get list of Properties",
     *      description="Returns list of Properties",
     *     @OA\Response(
     *          response="200",
     *          description="Get all Properties"
     *       )
     * )
     */
    public function index(Request $request)
    {
        $data = new Property;
        $search = $request->filter_search;
        $type = $request->type;
        $status = $request->status;
        $sortKey = $request->sortKey;
        $sortOrder = $request->sortOrder;

        if (isset($sortKey) && !empty($sortKey) && isset($sortOrder) && !empty($sortOrder)) {
            $data = (strtolower($sortOrder) == 'desc') ? $data->orderBy($sortKey, 'DESC') : $data->orderBy($sortKey, 'ASC');
        } else {
            $data = $data->orderBy('id', 'ASC');
        }

        if (isset($search) && !empty($search)) {
            $data = $data->where(function ($query) use ($search) {
                $query->where('address', 'like', '%' . $search . '%')->orWhere('price', 'like', '%' . $search . '%');
            });
        }

        if (isset($type) && !empty($type)) {
            $data = $data->where(function ($query) use ($type) {
                $query->whereIn('type', explode(',',$type));
            });
        }

        if (isset($status) && !empty($status)) {
            $data = $data->where(function ($query) use ($status) {
                $query->whereIn('status', explode(',', $status));
            });
        }

        $data = $data->paginate($this->perPage);

        return response()->json([
            'data' => [
                'properties' => new PropertiesCollection($data)
            ]
        ], 200);
    }

    /**
     * @OA\Post(
     *      path="/api/properties",
     *      operationId="createProperty",
     *      tags={"Properties"},
     *      summary="Create property",
     *      description="Create a new property with the specified details.<br>type(ENUM) = 'house, apartment, land' <br> status (ENUM) = 'available, rented, sold'",
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
    public function store(PropertyRequest $request)
    {
        $property = Property::create([
            'type' => $request->type,
            'address' => $request->address,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return response()->json(['data' => new PropertiesResource($property), 'message' => __('global.Save succesfully.')], 200);
    }

    /**
     * @OA\Put(
     *      path="/api/properties/{id}",
     *      operationId="updateProperty",
     *      tags={"Properties"},
     *      summary="Update existing property",
     *      description="Returns updated property data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Property id",
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
    public function update(PropertyRequest $request, $id)
    {
        $property = Property::find($id);
        if (!isset($property->id) || empty($property->id)) return response()->json(['message' => 'Imóvel não foi encontrado'], 400);

        $property->update([
            'type' => $request->type,
            'address' => $request->address,
            'price' => $request->price,
            'status' => $request->status,
        ]);

        return response()->json(['data' => new PropertiesResource($property), 'message' => __('global.Save succesfully.')], 200);
    }

    /**
     * @OA\Delete(
     *      path="/api/properties/{id}",
     *      operationId="deleteProperty",
     *      tags={"Properties"},
     *      summary="Delete existing property",
     *      description="Deletes a record",
     *      @OA\Parameter(
     *          name="id",
     *          description="Property id",
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
        $property = Property::find($id);
        if (!isset($property->id) || empty($property->id)) return response()->json(['message' => 'Imóvel não foi encontrado'], 400);
        $property->delete();
        return response()->json(['message' => 'Deletado com sucesso'], 200);
    }

    /**
     * @OA\Get(
     *     path="/api/properties/{id}",
     *     operationId="getPropertiesById",
     *      tags={"Properties"},
     *      summary="Get property information",
     *      description="Returns property data",
     *      @OA\Parameter(
     *          name="id",
     *          description="Property id",
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
        $property = Property::find($id);
        if (!isset($property->id) || empty($property->id)) return response()->json(['message' => 'Imóvel não foi encontrado'], 400);
        return response()->json(['data' => new PropertiesResource($property)], 200);
    }
}
