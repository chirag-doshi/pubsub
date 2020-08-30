<?php

namespace Tests\Unit;

use App\Http\Controllers\SubscriptionController;
use Faker\Factory;
use Illuminate\Http\Request;
use Tests\TestCase;


class SubscriptionControllerTest extends TestCase
{
    /**
     * Test subscribe method
     *
     * @return void
     */
    public function testSubscribe()
    {
        $data = [
            'url' => $this->faker->url
        ];
        $title = $this->faker->sentence;
        $this->post(route('subscribe', $title), $data)
            ->assertStatus(200)
            ->assertExactJson(['success' => "Topic: $title is subscribed"])
        ;
    }
    public function testSubscribeWithUrlBlank()
    {
        $data = [
            'url' => ''
        ];
        $title = $this->faker->sentence;
        $this->post(route('subscribe', $title), $data)
            ->assertStatus(200)
            ->assertExactJson(['error' => "Check if topic and url is not empty", 'failed' => "Failed to add the subscription"])
        ;
    }

    public function testSubscribeWithNoUrl()
    {
        $data = [
        ];
        $title = $this->faker->sentence;
        $this->post(route('subscribe', $title), $data)
            ->assertStatus(200)
            ->assertExactJson(['error' => "Check if topic and url is not empty", 'failed' => "Failed to add the subscription"])
        ;
    }

    public function testSubscribeWithBlankTitle()
    {
        $data = [
            'url' => $this->faker->url
        ];
        $title = '';
        $this->post(route('subscribe', $title), $data)
            ->assertStatus(404)
        ;
    }
}
