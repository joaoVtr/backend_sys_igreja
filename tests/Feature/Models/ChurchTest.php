<?php

namespace Tests\Feature\Models;

use App\Models\Church;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Http\UploadedFile;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class ChurchTest extends TestCase
{
    use DatabaseTransactions;

    public $url = '/api/churches';

    public function setUp(): void
    {
        parent::setUp();

        Church::factory()->count(2)->create();
    }

    /**
     * get all churches.
     *
     * @return void
     */
    public function test_get_all_churches()
    {
        $response = $this->getJson("{$this->url}");

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
        $json->has('data'));
        // dd(json_decode($response->getContent()));
    }

    /**
     * wrong endpoint to get all
     * 
     */
    public function test_fail_get_all_churches()
    {
        $this->url = 'api/church';

        $response = $this->getJson("{$this->url}");

        $response->assertStatus(404);
    }

    /**
     * show one church
     */
    public function test_show_church()
    {
        $church = Church::factory()->create();

        $response = $this->getJson("{$this->url}/{$church->id}");

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
        $json->has('data'));
    }

    /**
     * fail to show one church
     */
    public function test_fail_show_church()
    {
        $response = $this->getJson("{$this->url}/-1");

        $response->assertStatus(404);
    }

    /**
     * delete a church
     */
    public function test_delete_church()
    {
        $church = Church::factory()->create();

        $response = $this->deleteJson("{$this->url}/{$church->id}");

        $response->assertStatus(204);
    }

    /**
     * fail to delete a church
     */
    public function test_fail_delete_church()
    {
        $response = $this->deleteJson("{$this->url}/-1");

        $response->assertStatus(404);
    }

    /**
     * create new church
     */
    public function test_create_church()
    {
        $file = UploadedFile::fake()->create('test.jpg');

        $payload = [
            'name' => fake()->company(),
            'address' => fake()->address('pt_BR'),
            'website' => fake()->url(),
            'picture' => $file,
        ];

        $response = $this->postJson($this->url, $payload);

        $response->assertStatus(201)->assertJson(fn (AssertableJson $json) =>
        $json->has('data'));
    }

    /**
     * fail create new church
     * 
     */
    public function test_fail_create_church()
    {
        $payload = [
            'name' => null,
            'address' => fake()->address('pt_BR'),
            'website' => fake()->url(),
        ];

        $response = $this->postJson($this->url, $payload);

        $response->assertStatus(422)->assertJson(fn (AssertableJson $json) =>
        $json->hasAny('message', 'errors'));
    }

    /**
     * update church
     */
    public function test_update_church()
    {
        $church = Church::factory()->create();

        $payload = [
            'name' => fake()->company(),
            'address' => fake()->address('pt_BR'),
            'website' => fake()->url(),
        ];
        $response = $this->putJson("{$this->url}/{$church->id}", $payload);

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
        $json->has('data'));
    }

    /**
     * fail update church
     */
    public function test_fail_update_church()
    {
        $payload = [
            'name' => fake()->company(),
            'address' => fake()->address('pt_BR'),
            'website' => fake()->url(),
            'picture' => fake()->filePath(),
        ];

        $response = $this->putJson("{$this->url}/-1", $payload);

        $response->assertStatus(404);
    }
}
