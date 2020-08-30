<?php


namespace Tests\Unit;


use App\Event;
use App\Repositories\EventRepository;
use Tests\TestCase;

class EventRepositoryTest extends TestCase
{
    public function testCreateAnEvent()
    {
        $data = factory(Event::class)->make();
        (new EventRepository())->createEvent($data->data, $data->topic);
        $this->assertDatabaseHas('events', $data->toArray());

    }

}
