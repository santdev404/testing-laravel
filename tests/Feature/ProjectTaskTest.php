<?php

namespace Tests\Feature;

use App\Project;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ProjectTaskTest extends TestCase
{

    use RefreshDatabase;

    /** @test */
    public function guests_cannot_add_tasks_to_project(){
        $project = factory(Project::class)->create();

        $this->post($project->path().'/tasks')->assertRedirect('login');
    }

    /** @test */
    public function only_the_owner_of_a_project_may_add_tasks(){

        $this->signIn();

        $project = factory(Project::class)->create();

        $attributes = ['body'=>'Test task'];

        $this->post($project->path().'/tasks', $attributes)->assertStatus(403);

        $this->assertDatabaseMissing('tasks', $attributes);

    }

    /** @test */
    public function only_the_owner_of_a_project_may_update_task(){

        $this->signIn();

        $project = factory(Project::class)->create();
        
        $task = $project->addTask('Test task');

        $this->patch($task->path(), ['body'=>'changed', 'completed' => 1])->assertStatus(403);

        $this->assertDatabaseMissing('tasks', [
            'body' => 'Test task',
            'completed' => 1]);

    }

    /** @test */
    public function a_task_can_be_updated(){

        $this->withoutExceptionHandling();

        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $task = $project->addTask('Task test');

        $this->patch($task->path(),[
            'body'=> 'changed',
            'completed' => true
        ]);

        $this->assertDatabaseHas('tasks',[
            'body'=> 'changed',
            'completed' => true
        ]);

    }

    /** @test */
    public function a_project_can_have_tasks()
    {
        $this->signIn();

        //$project = factory(Project::class)->create(['owner_id' => auth()->id()]);


        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $this->post($project->path().'/tasks', ['body' => 'Test task']);

        $this->get($project->path())->assertSee('Test task');

    }


    /** @test */
    public function a_test_require_a_body()
    {
        $this->signIn();

        $project = auth()->user()->projects()->create(
            factory(Project::class)->raw()
        );

        $attributes = factory('App\Task')->raw(['body'=> '']);

        $this->post($project->path().'/tasks',$attributes)->assertSessionHasErrors('body');

    }
}
