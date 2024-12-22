<?php

namespace Tests\Feature;

use Mockery;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    #[Test] public function test_login_success()
    {
        $requestData = [
            'email' => 'superadmin@example.com',
            'password' => 'password'
        ];

        $response = $this->postJson(route('auth.login'), $requestData);

        $response->assertStatus(200);
    }

    #[Test] public function test_refresh_success()
    {

        $requestData = [
            'email' => 'superadmin@example.com',
            'password' => 'password'
        ];

        $responseLogin = $this->postJson(route('auth.login'), $requestData);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$responseLogin['data']['access_token'],
        ])->postJson(route('auth.refresh'));

        $response->assertStatus(200)->assertJsonStructure(['data' => ['access_token']]);
    }

    #[Test] public function test_logout_success()
    {

        $requestData = [
            'email' => 'superadmin@example.com',
            'password' => 'password'
        ];

        $responseLogin = $this->postJson(route('auth.login'), $requestData);

        $response = $this->withHeaders([
            'Authorization' => 'Bearer '.$responseLogin['data']['access_token'],
        ])->postJson(route('auth.logout'));

        $response->assertStatus(200);
    }

    /**
     * Test login failure with invalid credentials.
     */
    public function test_login_failure_with_invalid_credentials()
    {
        $response = $this->postJson(route('auth.login'), [
            'email' => 'wrong-email@example.com',
            'password' => 'wrong-password',
        ]);

        $response->assertStatus(401);
    }

    /**
     * Test logout failure without token.
     */
    public function test_logout_failure_without_token()
    {
        $response = $this->postJson(route('auth.logout'));

        $response->assertStatus(401);
    }

    /**
     * Test refresh failure with invalid token.
     */
    public function test_refresh_failure_with_invalid_token()
    {
        $invalidToken = 'this-is-an-invalid-token';

        $response = $this->withHeaders([
            'Authorization' => "Bearer $invalidToken",
        ])->postJson('/api/refresh');

        $response->assertStatus(404);
    }

    /**
     * Test logout failure with invalid token.
     */
    public function test_logout_failure_with_invalid_token()
    {
        $invalidToken = 'this-is-an-invalid-token';

        $response = $this->withHeaders([
            'Authorization' => "Bearer $invalidToken",
        ])->postJson(route('auth.logout'));

        $response->assertStatus(401);
    }

    protected function tearDown(): void
    {
        Mockery::close(); // Close mockery
        parent::tearDown();
    }
}
