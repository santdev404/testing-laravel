<?php

namespace Tests\Unit;

use Facades\Tests\Setup\ProjectFactory;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function a_user_has_projects(){

        $user = factory('App\User')->create();

        
        $this->assertInstanceOf(Collection::class, $user->projects);

    }

    /** @test */
    public function a_user_has_accesible_projects()
    {
        $john = $this->signIn();

        ProjectFactory::ownedBy($john)->create();

        $this->assertCount(1, $john->accesibleProjects());

        $sally = factory(\App\User::class)->create();
        $nick = factory(\App\User::class)->create();


        $project = tap(ProjectFactory::ownedBy($sally)->create())->invite($nick);



        $this->assertCount(1, $john->accesibleProjects());

        $project->invite($john);

        $this->assertCount(2, $john->accesibleProjects());



    }

}
