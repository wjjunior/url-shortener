<?php

namespace Tests\Feature\Http\GraphQL;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Faker\Factory;

class UrlMutatorTest extends TestCase
{
    use DatabaseMigrations;

    /**
     * @test
     */
    public function can_create_a_shortlink_without_short_parameter()
    {
        $appUrl = env('APP_URL');
        $faker = Factory::create();
        $link = $faker->url;


        $response = $this->graphQL(
        /** @lang GraphQL */
            '
            mutation CreateUrl($input: UrlInput!) {
                createUrl(input: $input) {
                    shortlink
                }
            }
        ',
            [
                'input' => [
                    'link' => $link
                ]
            ]
        );

        $shortLinkLength = strlen($appUrl) + 10;

        $shortLink = $response->json("data.createUrl.shortlink");

        $this->assertNotNull($shortLink);
        $this->assertIsString($shortLink);
        $this->assertStringContainsString($appUrl, $shortLink);
        $this->assertGreaterThanOrEqual($shortLinkLength, strlen($shortLink));
        $this->assertDatabaseHas('urls', [
            'link' => $link,
            'shortlink' => $shortLink
        ]);
    }

    /**
     * @test
     */
    public function can_create_a_shortlink_whith_short_parameter()
    {
        $appUrl = env('APP_URL');
        $faker = Factory::create();
        $link = $faker->url;
        $short = $faker->word;


        $response = $this->graphQL(
        /** @lang GraphQL */
            '
            mutation CreateUrl($input: UrlInput!) {
                createUrl(input: $input) {
                    shortlink
                }
            }
        ',
            [
                'input' => [
                    'link' => $link,
                    'short' => $short
                ]
            ]
        );

        $shortLinkLength = strlen($appUrl) + strlen($short) + 4;

        $shortLink = $response->json("data.createUrl.shortlink");

        $this->assertNotNull($shortLink);
        $this->assertIsString($shortLink);
        $this->assertStringContainsString($appUrl, $shortLink);
        $this->assertStringContainsString($short, $shortLink);
        $this->assertGreaterThanOrEqual($shortLinkLength, strlen($shortLink));
        $this->assertDatabaseHas('urls', [
            'link' => $link,
            'shortlink' => $shortLink
        ]);
    }
}
