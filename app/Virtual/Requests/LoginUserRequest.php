<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Login User Request",
 *      description="Login user request body data",
 *      type="object",
 *      required={"email", "password"}
 * )
 */

class LoginUserRequest
{
    /**
     * @OA\Property(
     *      title="email",
     *      description="Email of the new property",
     *      example="teste@teste.com.br"
     * )
     *
     * @var string
     */
    public $email;

    /**
     * @OA\Property(
     *      title="password",
     *      description="Password of the new property",
     *      example=""
     * )
     *
     * @var string
     */
    public $password;

}
