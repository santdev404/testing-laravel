<?php

namespace App\Http\Controllers;

use App\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(){
        $projects = Project::all();
        return view('projects.index', compact('projects'));
    }

    public function store(){

        auth()->user()->projects()->create(request()->validate([
            'title'=>'required',
            'description'=>'required',
        ]));

        return redirect('/projects');

    }

    public function show(Project $project){
        // $project = Project::find($project);
        // $project = Project::findOrFail(request('project'));
        return view('projects.show', compact('project'));
    }
}
