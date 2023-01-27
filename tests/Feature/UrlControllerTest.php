<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use App\Models\Url;
use App\Models\User;

class UrlControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function testShowDashboard()
    {
        $user = User::factory()->create();
        Url::factory()->create(['user_id' => $user->id]);

        $this->actingAs($user);

        $response = $this->get(route('dashboard'));

        $response->assertSuccessful();
        $response->assertViewIs('dashboard');
        $response->assertViewHas('data');
    }

    /** @test */
    public function testUrlStore()
    {
        $user = User::factory(User::class)->create();
        $this->actingAs($user);

        $validatedData = [
            'destination' => 'https://www.example.com',
        ];

        $response = $this->post(route('url.store'), $validatedData);
        $response->assertStatus(302);

        $response->assertSessionHas('success', 'URL successfully shortened!');

        $this->assertDatabaseHas('urls', [
            'destination' => $validatedData['destination'],
            'user_id' => $user->id,
        ]);
    }


    /** @test */
    public function testApiShorten()
    {
        $response = $this->json('POST', '/api/shorten', ['destination' => 'https://example.com']);

        $response->assertStatus(200);
        $json = $response->json();

        $response->assertJson([
            'destination' => 'https://example.com',
            "slug" => $json['slug'],
            "updated_at" => $json['updated_at'],
            "created_at" => $json['created_at'],
            "id" => $json['id'],
            'shortened_url' => $json['shortened_url']
        ]);

        $response2 = $this->json('POST', '/api/shorten', ['destination' => 'https://example.com']);

        $response2->assertStatus(200);

        $response2->assertJson([
            'destination' => 'https://example.com',
            "updated_at" => $json['updated_at'],
            "created_at" => $json['created_at'],
        ]);

        $response2->assertJsonFragment(['slug' => $response2->json()['slug']]);

        $response2->assertJsonFragment(['shortened_url' => $response2->json()['shortened_url']]);
    }


    /** @test */
    public function testRedirectToDest()
    {
        Url::factory()->create(['slug' => 'testslug2', 'destination' => 'https://www.google.com']);

        $response = $this->get('/testslug2');

        $response->assertStatus(302);
        $response->assertRedirect('https://www.google.com');
    }
}
