<?php

namespace Tests\Feature;

use Tests\TestCase;

class ManagerControllerTest extends TestCase
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
        ])->getJson(route('managers.index'));

        $this->assertTrue(in_array($response->status(), [200, 404]));
    }

    /**
     * Test show method.
     */
    public function test_show_method()
    {
        $id = 1;

        $response = $this->withHeaders([
            'Authorization' => "Bearer {$this->authToken}",
        ])->getJson(route('managers.show', $id));

        $this->assertTrue(in_array($response->status(), [200, 404]));
    }

}
