<?php


namespace App\Repositories;


use App\Subscriber;
use Illuminate\Http\Request;

class SubscriberRepository
{

    /**
     * @param $topic
     * @return mixed
     */
    public function getAllSubscribers($topic)
    {
        $subscriber = new Subscriber;
        return $subscriber::where('topic', $topic)->get();
    }

    /**
     * @param Request $request
     * @param $topic
     * @return Subscriber
     */
    public function createSubscriber(Request $request, $topic): Subscriber
    {
        $subscriber = new Subscriber;
        $subscriber->topic = $topic;
        $subscriber->url = $request->url;
        $subscriber->save();

        return $subscriber;
    }

}
