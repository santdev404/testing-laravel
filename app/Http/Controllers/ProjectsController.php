<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(){
        // $projects = Project::all();
        $projects = auth()->user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function store(){

        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);


        $project = auth()->user()->projects()->create($attributes);
        

        return redirect($project->path());

    }

    public function create(){
        return view('projects.create');
    }

    public function show(Project $project){

        $this->authorize('update', $project);

        return view('projects.show', compact('project'));
    }


    public function edit(Project $project)
    {
        return view('projects.edit', compact('project'));
    }

    public function update(Project $project){

        $this->authorize('update', $project);

        $attributes = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'notes' => 'min:3'
        ]);

        $project->update($attributes);

        return redirect($project->path());

    }
}
