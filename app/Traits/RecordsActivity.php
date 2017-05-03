<?php

namespace App\Traits;

use App\Activity;

trait RecordsActivity
{
    protected static function bootRecordsActivity()
    {
        if (auth()->guest())
            return;
        self::created(function($subject) {
            $subject->recordActivity('created');
        });
    }

    private function recordActivity($event)
    {
        $this->activity()->create([
            'user_id' => auth()->id(),
            'activity' => $this->getActivityName($event)
        ]);
    }

    private function getActivityName($event)
    {
        $shortClassName = strtolower(class_basename($this));
        return "{$event}_{$shortClassName}";
    }

    public function activity()
    {
        return $this->morphMany(Activity::class, 'subject');
    }
}