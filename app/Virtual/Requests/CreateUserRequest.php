<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Create User Request",
 *      description="Create user request body data",
 *      type="object",
 *      required={"name", "email", "password", "c_password"}
 * )
 */

class CreateUserRequest
{
    /**
     * @OA\Property(
     *      title="name",
     *      description="Name of the new property",
     *      example="Ezequiel Dias"
     * )
     *
     * @var string
     */
    public $name;

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
