<?php

namespace Tests\Unit;

use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTest extends TestCase
{

    use WithFaker,RefreshDatabase;

    /** @test */
    public function it_has_a_path(){

        $project = factory('App\Project')->create();

        $project->path();

        $this->assertEquals('/projects/'.$project->id, $project->path());
    }

    /** @test */
    public function it_belongs_to_an_owner()
    {

        $project = factory('App\Project')->create();
        
        $this->assertInstanceOf('App\User', $project->owner);

    }
}
