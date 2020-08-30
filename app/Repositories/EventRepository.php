<?php


namespace App\Repositories;


use App\Event;
use Illuminate\Http\Request;

class EventRepository
{
    public function createEvent($data, $topic): Event
    {
        $event = new Event;
        $event->topic = $topic;
        $event->data = $data;
        $event->save();

        return $event;
    }

}
