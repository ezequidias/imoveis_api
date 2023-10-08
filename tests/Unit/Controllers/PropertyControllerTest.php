<?php

namespace Tests\Unit\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\User;
use App\Models\Property;
use Laravel\Sanctum\Sanctum;


class PropertyControllerTest extends TestCase
{
    use RefreshDatabase;

    private $property;
    private $user;
    private $perPage = 50;

    public function setUp(): void
    {
        parent::setUp();
        $this->property = Property::factory()->create();
        // Create a user and authenticate with Sanctum
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_fetch_all_properties()
    {
        Property::factory()->count(3)->make();
        $response = $this->get('api/properties');
        $response
            ->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        'properties' => [
                            'data' => [
                                '*' => [
                                    'id',
                                    'type',
                                    'address',
                                    'price',
                                    'status',
                                    'created_at',
                                    'updated_at',
                                ]
                            ],
                            'current_page',
                            'per_page',
                            'total',
                        ]
                    ]
                ]
            );
    }

    public function test_incorrect_field_id_in_property_by_id()
    {
        $response = $this->get('api/properties/0');
        $response
            ->assertStatus(400)
            ->assertExactJson(
                [
                    'message' => 'Imóvel não foi encontrado'
                ]
            );
    }

    public function test_get_property_by_id()
    {
        $property = Property::factory()->create();
        $response = $this->get('api/properties/' . $property->id);
        $response
            ->assertOk()
            ->assertExactJson(
                [
                    'data' =>[
                        'id' => $property->id,
                        'type' => $property->type,
                        'address' => $property->address,
                        'price' => (string) $property->price,
                        'status' => $property->status,
                        'created_at' => $property->created_at ? $property->created_at->format('d/m/Y H:i:s') : null,
                        'updated_at' => $property->updated_at ? $property->updated_at->format('d/m/Y H:i:s') : null,
                    ]
                ]
            );
    }

    public function test_incorrect_field_id_in_update_property()
    {
        $response = $this->put('api/properties/0', [
            'type' => 'house',
            'address' => 'updated address',
            'price' => 500000,
            'status' => 'sold',
        ]);
        $response
            ->assertStatus(400)
            ->assertExactJson(
                [
                    'message' => 'Imóvel não foi encontrado'
                ]
            );
    }

    public function test_required_fields_for_update_property()
    {
        $this->put('api/properties/' . $this->property->id, [])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Erro",
                "errors" => [
                    "type" => ["O campo type é obrigatório."],
                    "address" => ["O campo endereço é obrigatório."],
                    "price" => ["O campo preço é obrigatório."],
                    "status" => ["O campo status é obrigatório."],
                ]
            ]);
    }

    public function test_update_property()
    {
        $response = $this->put('api/properties/' . $this->property->id, [
            'type' => 'house',
            'address' => 'Av. Faria Lima',
            'price' => 500000,
            'status' => 'sold',
        ])
            ->assertOk();
        $this->assertDatabaseHas('properties', [
            'id' => $this->property->id,
            'type' => 'house',
            'address' => 'Av. Faria Lima',
            'price' => (string) 500000,
            'status' => 'sold',
        ]);
    }

    public function test_incorrect_field_id_in_delete_property()
    {
        $response = $this->delete('api/properties/0');
        $response
            ->assertStatus(400)
            ->assertExactJson(
                [
                    'message' => 'Imóvel não foi encontrado'
                ]
            );
    }

    public function test_delete_property()
    {
        $property = Property::factory()->create();
        $response = $this->delete('api/properties/' . $this->property->id)
            ->assertOk()
            ->assertExactJson(
                [
                    'message' => 'Deletado com sucesso'
                ]
            );
    }
}
