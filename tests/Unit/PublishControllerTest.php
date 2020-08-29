<?php

namespace Tests\Unit;

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
            ->assertExactJson(['error' => "No subscribers found"])
        ;
    }
    public function testPublishWithSubscribersButInvalidUrl()
    {
        $subscriber = factory(Subscriber::class)->create();
        $data = [
            'message' => $this->faker->sentence
        ];
        $response = [
            'error' => "Failed to post to some subscribers",
            "subscribers" => [$subscriber->url]
            ];
        $title = $subscriber->topic;
        $this->post(route('publish', $title), $data)
            ->assertStatus(200)
            ->assertExactJson($response)
        ;
    }

}
