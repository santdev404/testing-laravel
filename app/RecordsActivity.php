<?php

namespace App;

trait RecordsActivity
{
    public $old = [];

    public function recordActivity($description){

        return  $this->activity()->create([
            'description' => $description,
            'project_id' => class_basename($this) === 'Project' ? $this->id : $this->project_id,
            'changes' => $this->activityChanges(),
        ]);
    }


    public function activity(){
        return $this->morphMany(Activity::class, 'subject')->latest();
    }

    public function activityChanges()
    {
        if($this->wasChanged()){
            return [
                'before' => array_except(array_diff($this->old, $this->getAttributes()), 'updated_at'),
                'after' => array_except($this->getChanges(),  'updated_at')
            ];
        }

    }
}