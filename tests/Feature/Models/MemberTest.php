<?php

namespace Tests\Feature\Models;

use App\Models\Church;
use App\Models\Member;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class MemberTest extends TestCase
{
    use DatabaseTransactions;

    public $url = '/api/members';

    public function setUp(): void
    {
        parent::setUp();

        Church::factory()->count(2)->create();

        $this->member =  Member::factory()->count(3)->state(new Sequence(
            fn () => ['church_id' => Church::all()->random()]
        ))->create();
    }

    /**
     * get all members.
     *
     * @return void
     */
    public function test_get_all_members()
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
    public function test_fail_get_all_members()
    {
        $this->url = 'api/member';

        $response = $this->getJson("{$this->url}");

        $response->assertStatus(404);
    }

    /**
     * show one member
     */
    public function test_show_member()
    {
        $church = Church::factory()->create();

        $member =  Member::factory()->for($church)->create();

        $response = $this->getJson("{$this->url}/{$member->id}");

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
        $json->has('data'));
    }

    /**
     * fail to show one member
     */
    public function test_fail_show_member()
    {
        $response = $this->getJson("{$this->url}/-1");

        $response->assertStatus(404);
    }

    /**
     * delete a member
     */
    public function test_delete_member()
    {
        $church = Church::factory()->create();

        $member =  Member::factory()->for($church)->create();

        $response = $this->deleteJson("{$this->url}/{$member->id}");

        $response->assertStatus(204);
    }

    /**
     * fail to delete a member
     */
    public function test_fail_delete_member()
    {
        $response = $this->deleteJson("{$this->url}/-1");

        $response->assertStatus(404);
    }

    /**
     * create new member
     */
    public function test_create_member()
    {
        $church = Church::factory()->create();

        $payload = [
            'church_id' => $church->id,
            'name' => fake()->name(),
            'cpf' => fake()->numerify('###.###.###-##'),
            'birthday' => fake()->date(),
            'email' => fake()->safeEmail(),
            'cell_number' => fake()->numerify('(##)#####-####'),
            'street_name' => fake()->streetName(),
            'city' => fake()->city(),
            'state' => fake()->countryCode(),
        ];

        $response = $this->postJson($this->url, $payload);

        $response->assertStatus(201)->assertJson(fn (AssertableJson $json) =>
        $json->has('data'));
    }
    /**
     * fail create new member
     */
    public function test_fail_create_member()
    {
        $payload = [
            'name' => fake()->name(),
            'cpf' => fake()->numerify('###.###.###-##'),
            'birthday' => fake()->date(),
            'email' => fake()->safeEmail(),
            'cell_number' => fake()->numerify('(##)#####-####'),
            'street_name' => fake()->streetName(),
            'city' => fake()->city(),
            'state' => fake()->countryCode(),
        ];

        $response = $this->postJson($this->url, $payload);

        $response->assertStatus(422)->assertJson(fn (AssertableJson $json) =>
        $json->hasAny('message', 'errors'));
    }

    /**
     * update member
     */
    public function test_update_member()
    {
        $church = Church::factory()->create();

        $member =  Member::factory()->for($church)->create();
        $payload = [
            'church_id' => $church->id,
            'name' => fake()->name(),
            'cpf' => fake()->numerify('###.###.###-##'),
            'birthday' => fake()->date(),
            'email' => fake()->safeEmail(),
            'cell_number' => fake()->numerify('(##)#####-####'),
            'street_name' => fake()->streetName(),
            'city' => fake()->city(),
            'state' => fake()->countryCode(),
        ];

        $response = $this->putJson("{$this->url}/{$member->id}", $payload);

        $response->assertStatus(200)->assertJson(fn (AssertableJson $json) =>
        $json->has('data'));
    }
    /**
     * fail update member
     */
    public function test_fail_update_member()
    {
        $payload = [
            'name' => fake()->name(),
            'cpf' => fake()->numerify('###.###.###-##'),
            'birthday' => fake()->date(),
            'email' => fake()->safeEmail(),
            'cell_number' => fake()->numerify('(##)#####-####'),
            'street_name' => fake()->streetName(),
            'city' => fake()->city(),
            'state' => fake()->countryCode(),
        ];

        $response = $this->putJson("{$this->url}/-1", $payload);

        $response->assertStatus(404);
    }
}
