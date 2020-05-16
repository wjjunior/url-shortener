<?php

namespace Tests\Feature\Http\GraphQL;

use App\Url;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Faker\Factory;

class UrlControllerTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_return_redirect_view()
    {
        $url = factory(Url::class)->create();

        $response = $this->get($url->shortlink);

        $response->assertViewHas('url', $url->link);
        $response->assertViewIs('redirect');
    }


    /**
     * @test
     */
    public function will_fail_with_a_404_error_for_invalid_shortlinks()
    {
        $faker = Factory::create();
        $short = $faker->word;
        $appUrl = env('APP_URL');
        $response = $this->get($appUrl . $short);

        $response->assertStatus(404);
    }
}
