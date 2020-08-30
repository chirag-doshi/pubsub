<?php


namespace App\Http\Controllers;


use App\Event;
use App\Events\TopicPublished;
use App\Repositories\EventRepository;
use App\Subscriber;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;
use Illuminate\Support\Facades\Log;

class PublishController extends Controller
{
    public $eventRepository;

    public function __construct(EventRepository $eventRepository)
    {
        $this->eventRepository = $eventRepository;
    }

    /**
     * @param Request $request
     * @param $topic
     * @return array
     * @throws GuzzleException
     */
    public function publish(Request $request, $topic): array
    {
        Log::info('Somthing logged');
        $eventPublished = $this->eventRepository->createEvent(json_encode($request->all()), $topic);
        if ($eventPublished) {
            event(new TopicPublished($eventPublished));
            return ['success' => 'Event published'];
        }
        return ['failure' => 'Event not published'];
    }

    public function receiveEvents(Request $request)
    {
        Log::info(json_encode($request->all()));
    }
}
