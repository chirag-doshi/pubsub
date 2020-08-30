<?php

namespace Tests\Unit;

use App\Event;
use App\Events\TopicPublished;
use App\Repositories\EventRepository;
use App\Subscriber;
use Tests\TestCase;

class PublishControllerTest extends TestCase
{
    /**
     * Test publish endpoint
     *
     * @return void
     */
    public function testPublishWithNoSubscribers()
    {
        $data = [
            'message' => $this->faker->sentence
        ];
        $title = $this->faker->sentence;
        $this->post(route('publish', $title), $data)
            ->assertStatus(200)
            ->assertExactJson(['success' => "Event published"])
        ;
    }

    public function testTopicPublishedIsDispatched()
    {
        \Illuminate\Support\Facades\Event::fake();
        $subscriber = factory(Subscriber::class)->create();
        $data = [
            'message' => $this->faker->sentence
        ];
        $title = $subscriber->topic;
        $this->post(route('publish', $title), $data);

        \Illuminate\Support\Facades\Event::assertDispatched(TopicPublished::class);

    }

}
