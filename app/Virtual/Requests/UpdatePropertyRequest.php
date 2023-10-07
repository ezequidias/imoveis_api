<?php

namespace App\Virtual\Requests;

/**
 * @OA\Schema(
 *      title="Update Property Request",
 *      description="Update Property request body data",
 *      type="object",
 *      required={"id", "type", "address", "price", "status"}
 * )
 */

class UpdatePropertyRequest
{
    /**
     * @OA\Property(
     *      title="id",
     *      description="ID of the property",
     *      example="1"
     * )
     *
     * @var int
     */
    public $id;

    /**
     * @OA\Property(
     *      title="type",
     *      description="Type of the new property",
     *      enum={"house", "apartment", "land"},
     *      example="house"
     * )
     *
     * @var string
     */
    public $type;

    /**
     * @OA\Property(
     *      title="address",
     *      description="Address of the new property",
     *      example="Av. Brig. Faria Lima, 1721 - Jardim Paulistano, São Paulo - SP, 01452-001"
     * )
     *
     * @var string
     */
    public $address;

    /**
     * @OA\Property(
     *      title="price",
     *      description="Price of the new property",
     *      example="400000.00"
     * )
     *
     * @var float
     */
    public $price;

    /**
     * @OA\Property(
     *      title="status",
     *      description="Status of the new property",
     *      enum={"available", "rented", "sold"},
     *      example="available"
     * )
     *
     * @var string
     */
    public $status;

}
