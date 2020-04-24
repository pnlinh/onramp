<?php

namespace Tests\Feature;

use App\Module;
use App\Track;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class MyModulesPageTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function my_modules_page_only_lists_modules_in_users_track()
    {
        $track = factory(Track::class)->create();
        $track->modules()->createMany(
            factory(Module::class, 3)->make([
                'is_bonus' => 0,
            ])->toArray()
        );

        $otherTrack = factory(Track::class)->create();
        $otherTrack->modules()->createMany(
            factory(Module::class, 2)->make([
                'is_bonus' => 0,
            ])->toArray()
        );

        $user = factory(User::class)->create([
            'track_id' => 1,
        ]);

        $this->actingAs($user);

        $response = $this->get(route('home', ['locale' => 'en']));

        $response->assertViewHas('modules', function ($modules) {
            return $modules->count() == 3;
        });
    }
}