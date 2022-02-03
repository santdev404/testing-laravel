<?php

namespace Tests\Unit;

use App\Project;
use App\Task;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use WithFaker,RefreshDatabase;

    /** @test */
    public function it_belongs_to_a_project(){
        $task = factory(Task::class)->create();
        $this->assertInstanceOf(Project::class, $task->project);
    }

    /** @test */
    public function it_has_a_path(){

        //$this->withoutExceptionHandling();

        $task = factory(Task::class)->create();

        $this->assertEquals("/projects/{$task->project->id}/tasks/{$task->id}", $task->path());
    }
}
