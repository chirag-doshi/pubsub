<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class Subscriber extends Model
{
    protected $fillable = ['topic', 'url'];

    /**
     * @param $topic
     * @return mixed
     */
    public function getAllSubscribers($topic)
    {
        return self::where('topic', $topic)->get();
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
