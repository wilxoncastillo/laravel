<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

// add
use App\User;
use App\Team;


class SearchUsersTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function search_users_by_name()
    {
        factory(User::class)->create([
        	'first_name' => 'Joel'
        ]);

        factory(User::class)->create([
        	'first_name' => 'Ellie'
        ]);

        $this->get('/users?search=Joel')
        	->assertStatus(200)
        	->assertSee('Listado de usuarios')
        	->assertSee('Joel')
        	->assertDontSee('Ellie');

    }

    /** @test */
    public function show_results_with_a_partial_search_by_name()
    {
        $joel =factory(User::class)->create([
        	'first_name' => 'joel'
        ]);

        $ellie = factory(User::class)->create([
        	'first_name' => 'Ellie'
        ]);

        $this->get('/users?search=joe')
        	->assertStatus(200)
        	->assertViewHas('users', function ($users) use ($joel, $ellie) {
        		return $users->contains($joel) && !$users->contains($ellie);
        	});

    }

    /** @test */
    public function search_users_by_email()
    {
        $joel =factory(User::class)->create([
        	'email' => 'joel@example.com'
        ]);

        $ellie = factory(User::class)->create([
        	'email' => 'ellie@example.com'
        ]);

        $this->get('/users?search=joel@example.com')
        	->assertStatus(200)
        	->assertViewHas('users', function ($users) use ($joel, $ellie) {
        		return $users->contains($joel) && !$users->contains($ellie);
        	});
    }

    /** @test */
    public function search_users_by_team_name()
    {
        $roxana =factory(User::class)->create([
            'first_name' => 'roxana',
            'team_id' => factory(Team::class)->create(['name' => 'Smuggler'])->id,
        ]);

        $vanessa = factory(User::class)->create([
            'first_name' => 'venessa',
            'team_id' => null,
        ]);

        $dulce = factory(User::class)->create([
            'first_name' => 'dulce',
            'team_id' => factory(Team::class)->create(['name' => 'Firefly'])->id,
        ]);

        $response = $this->get('/users?search=Fire')
            ->assertStatus(200);

        $response->assertViewCollection('users')
            ->contains($dulce)
            ->notContains($roxana)
            ->notContains($vanessa);
    }


}
