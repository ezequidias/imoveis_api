<?php

namespace App\Http\Controllers;

use App\Models\Property;
use App\Models\User;
use Illuminate\Http\Request;


class DashboardController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/dashboard",
     *     operationId="getInfoDashboard",
     *      tags={"Dashboard"},
     *      summary="Get info dashboard",
     *      description="Returns info dashboard",
     *     @OA\Response(
     *          response="200",
     *          description="Get info dashboard"
     *       )
     * )
     */
    public function index(Request $request)
    {
        return response()->json([
            'data' => [
                'total_users' => User::count(),
                'total_properties' => Property::count(),
            ]
        ], 200);
    }
}
