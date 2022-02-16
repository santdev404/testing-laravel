<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    //

    // public $fillable = ['title', 'description'];

    protected $guarded = [];

    public function path(){

        return "/projects/{$this->id}";
    }

    public function owner(){

        return $this->belongsTo(User::class);
    }

    public function tasks(){
        return $this->hasMany(Task::class);
    }

    public function addTask($body)
    {
        return $this->tasks()->create(compact('body'));

    }


    public function activity(){
        return $this->hasMany(Activity::class);
    }



    public function recordActivity($description){

       return  $this->activity()->create(compact('description'));
        // Activity::create([
        //     'project_id' => $this->id,
        //     'description' => $type
        // ]);
    }
}
