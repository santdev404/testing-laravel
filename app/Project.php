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
}
