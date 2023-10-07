<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 * title="Imóveis API Documentation",
 * version="1.0.0",
 * description="This is documentation to API Rest Imóveis",
 *      @OA\Contact(
 *          url="https://github.com/ezequidias"
 *      ),
 *      @OA\License(
 *          name="Apache 2.0",
 *          url="http://www.apache.org/licenses/LICENSE-2.0.html"
 *      )
 * )
 * @OA\Server(
 *      url=L5_SWAGGER_CONST_HOST,
 *      description="Demo API Server"
 * )
 *
 *  @OA\Tag(
 *     name="Auth",
 *     description="API Endpoints of Auth"
 * )
 * 
 *  @OA\Tag(
 *     name="Users",
 *     description="API Endpoints of Users"
 * )
 * 
 * @OA\Tag(
 *     name="Properties",
 *     description="API Endpoints of Properties"
 * )
 * 
 * @OA\Tag(
 *     name="Dashboard",
 *     description="API Endpoints of Dashboard"
 * )
 */

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
