<?php

namespace Tests\Feature;

use Faker\Factory as Faker;
use Tests\TestCase;

class CompanyControllerTest extends TestCase
{
    protected string $authToken;

    protected function setUp(): void
    {
        parent::setUp();

        $response = $this->postJson(route('auth.login'), [
            'email' => 'superadmin@example.com',
            'password' => 'password'
        ]);
        $this->authToken = $response['data']['access_token'];
    }

    /**
     * Test index method.
     */
    public function test_index_method()
    {

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->authToken}",
        ])->getJson(route('company.index'));

        $this->assertTrue(in_array($response->status(), [200, 404]));
    }

    /**
     * Test store method.
     */
    public function test_store_method()
    {
        $faker = Faker::create();

        $data = [
            'name' => $faker->company,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->authToken}",
        ])->postJson(route('company.store', $data));

        $response->assertStatus(201)
            ->assertJson([
                'rc' => '0201'
            ]);

        $this->assertDatabaseHas('companies', $data);
    }

    /**
     * Test show method.
     */
    public function test_show_method()
    {
        $id = 1;

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->authToken}",
        ])->getJson(route('company.show', $id));

        $this->assertTrue(in_array($response->status(), [200, 404]));
    }

    /**
     * Test update method.
     */
    public function test_update_method()
    {
        $faker = Faker::create();

        $data = [
            'name' => $faker->company,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->authToken}",
        ])->postJson(route('company.store', $data));

        $response->assertStatus(201)
            ->assertJson([
                'rc' => '0201'
            ]);

        $id = $response['data']['company']['id'];

        $updateName = 'Unit Test Edited'.$faker->company;
        $data['name'] = $updateName;

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->authToken}",
        ])->putJson(route('company.update', $id), $data);

        $response->assertStatus(200)
            ->assertJson([
                'data' => [
                    'company' => [
                        'name' => $updateName
                    ]
                ]
            ]);
    }

    /**
     * Test destroy method.
     */
    public function test_destroy_method()
    {
        $faker = Faker::create();

        $data = [
            'name' => $faker->company,
            'email' => $faker->email,
            'phone' => $faker->phoneNumber,
        ];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->authToken}",
        ])->postJson(route('company.store', $data));

        $response->assertStatus(201)
            ->assertJson([
                'rc' => '0201'
            ]);

        $id = $response['data']['company']['id'];

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->authToken}",
        ])->deleteJson(route('company.destroy', $id));

        $response->assertStatus(200);
    }
}
