<?php

namespace Tests\Unit\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Http\Response;
use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;


class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    private $user;
    private $perPage = 50;

    public function setUp(): void
    {
        parent::setUp();
        // Create a user and authenticate with Sanctum
        $this->user = User::factory()->create();
        Sanctum::actingAs($this->user);
    }

    public function test_fetch_all_users()
    {
        User::factory()->count(3)->make();
        $response = $this->get('api/users');
        $response
            ->assertOk()
            ->assertJsonStructure(
                [
                    'data' => [
                        'users' => [
                            'data' => [
                                '*' => [
                                    'id',
                                    'name',
                                    'email',
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

    public function test_incorrect_field_id_in_user_by_id()
    {
        $response = $this->get('api/users/0');
        $response
            ->assertStatus(400)
            ->assertExactJson(
                [
                    'message' => 'Usuário não foi encontrado'
                ]
            );
    }

    public function test_get_user_by_id()
    {
        $user = User::factory()->create();
        $response = $this->get('api/users/' . $user->id);
        $response
            ->assertOk()
            ->assertExactJson(
                [
                    'data' =>[
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ]
                ]
            );
    }

    public function test_incorrect_field_id_in_update_user()
    {
        $response = $this->put('api/users/0', [
            'name' => 'Ezequiel',
            'email' => 'demo@demo.com.br',
        ]);
        $response
            ->assertStatus(400)
            ->assertExactJson(
                [
                    'message' => 'Usuário não foi encontrado'
                ]
            );
    }

    public function test_required_fields_for_update_user()
    {
        $this->put('api/users/' . $this->user->id, [])
            ->assertStatus(422)
            ->assertJson([
                "message" => "Erro",
                "errors" => [
                    "name" => ["O campo nome é obrigatório."],
                    "email" => ["O campo e-mail é obrigatório."],
                ]
            ]);
    }

    public function test_update_user()
    {
        $response = $this->put('api/users/' . $this->user->id, [
            'name' => 'Ezequiel',
            'email' => 'demo@demo.com.br',
        ])
            ->assertOk();
        $this->assertDatabaseHas('users', [
            'id' => $this->user->id,
            'name' => 'Ezequiel',
            'email' => 'demo@demo.com.br',
        ]);
    }

    public function test_incorrect_field_id_in_delete_user()
    {
        $response = $this->delete('api/users/0');
        $response
            ->assertStatus(400)
            ->assertExactJson(
                [
                    'message' => 'Usuário não foi encontrado'
                ]
            );
    }

    public function test_delete_user()
    {
        $user = User::factory()->create();
        $response = $this->delete('api/users/' . $this->user->id)
            ->assertOk()
            ->assertExactJson(
                [
                    'message' => 'Deletado com sucesso'
                ]
            );
    }
}
