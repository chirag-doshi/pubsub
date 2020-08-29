<?php


namespace App\Http\Controllers;


use App\Subscriber;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{

    /**
     * @param Request $request
     * @param $topic
     * @return array
     */
    public function subscribe(Request $request, $topic): array
    {
        if (!$this->validateSubscriber($request, $topic)) {
            return ['failed' => 'Failed to add the subscription', 'error' => 'Check if topic and url is not empty'];
        }
        $subscriber = new Subscriber;
        $subscriber->createSubscriber($request, $topic);

        return ['success' => "Topic: $topic is subscribed"];

    }

    /**
     * @param $request
     * @param $topic
     * @return bool
     */
    public function validateSubscriber($request, $topic): bool
    {
        if (!empty($request->url) && !empty($topic)) {
            return true;
        }
        return false;
    }



}
