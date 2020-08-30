<?php

namespace App\Listeners;

use App\Events\TopicPublished;
use App\Repositories\SubscriberRepository;
use App\Subscriber;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PublishMessageToSubcribers implements ShouldQueue
{
    public $subscriberRepository;
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct(SubscriberRepository $subscriberRepository)
    {
        $this->subscriberRepository = $subscriberRepository;
    }

    /**
     * Handle the event.
     *
     * @param  TopicPublished  $event
     * @return void
     */
    public function handle(TopicPublished $event): void
    {
        $topic = $event->publishedEvent->topic;
        $data = $event->publishedEvent->data;
        $subscribers = $this->subscriberRepository->getAllSubscribers($topic);

        if ($subscribers->count()) {
            $this->postSubscriptions($subscribers, $data);
        }

    }

    public function postSubscriptions($subscribers, $data): bool
    {
        $client = new Client();
        foreach ($subscribers as $subscriberRecord) {
            try {
                $client->request('POST', $subscriberRecord->url, ['json' =>  $data]);
                Log::info($subscriberRecord->url);
            } catch (GuzzleException $exception) {
                // catching errors to send later
                Log::error('Failed to send to url:' . $subscriberRecord->url);
            }
        }
        return true;

    }
}
