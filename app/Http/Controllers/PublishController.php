<?php


namespace App\Http\Controllers;


use App\Event;
use App\Subscriber;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\Request;
use GuzzleHttp\Client;

class PublishController extends Controller
{
    /**
     * @param Request $request
     * @param $topic
     * @return array
     * @throws GuzzleException
     */
    public function publish(Request $request, $topic): array
    {
        $event = new Event;
        $subscriber = new Subscriber;
        $subscribers = $subscriber->getAllSubscribers($topic);

        if ($subscribers->count() && $event->createEvent($request, $topic)) {
            return $this->postSubcriptions($subscribers, $request);
        }

        return ['error' => 'No subscribers found'];
    }

    /**
     * @param $subscribers
     * @param $request
     * @return array
     * @throws GuzzleException
     */
    public function postSubcriptions($subscribers, $request): array
    {
        $client = new Client();
        $errorSubscriberUrl = [];
        foreach ($subscribers as $subscriberRecord) {
            try {
                $client->request('POST',$subscriberRecord->url, ['json' =>  $request->all()]);
            } catch (GuzzleException $exception) {
                $errorSubscriberUrl = [$subscriberRecord->url];
            }
        }

        if (!empty($errorSubscriberUrl)) {
            return [
                'error' => 'Failed to post to some subscribers',
                'subscribers' => $errorSubscriberUrl
            ];
        }
        return ['success' => 'Post sent to subscribers'];
    }
}
