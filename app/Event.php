<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Event extends Model
{
    protected $fillable = ['topic', 'data'];


    public function createEvent(Request $request, $topic): Event
    {
        $event = new Event;
        $event->topic = $topic;
        $event->data = json_encode($request);
        $event->save();

        return $event;
    }
}
