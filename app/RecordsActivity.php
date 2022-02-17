<?php

namespace App;

trait RecordsActivity
{
    public $oldAttributes = [];


    public static function bootRecordsActivity(){

        // static::updating(function ($model){
        //     $model->oldAttributes = $model->getOriginal();
        // });
        
        foreach(self::recordableEvents()  as $event){
            static::$event(function ($model) use ($event){

                $model->recordActivity($model->activityDescription($event));

            });

            if($event === 'updated'){
                static::updating(function ($model){
                    $model->oldAttributes = $model->getOriginal();
                });
            }
        }



    }

    protected function activityDescription($description){
    
        if(class_basename($this) !== 'Project'){
            return "{$description}_".strtolower(class_basename($this));
        }

        return $description;
    }

    protected static function recordableEvents()
    {
        if(isset(static::$recordableEvents)){
            return static::$recordableEvents;
        }

        return ['created','updated','deleted'];
        
    }

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
                'before' => array_except(array_diff($this->oldAttributes, $this->getAttributes()), 'updated_at'),
                'after' => array_except($this->getChanges(),  'updated_at')
            ];
        }

    }
}