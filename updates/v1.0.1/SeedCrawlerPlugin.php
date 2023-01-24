<?php

namespace UnixDevil\Feeds\Updates;

use Faker\Factory;
use Faker\Generator;
use UnixDevil\Crawler\Models\Website;
use Winter\Storm\Database\Updates\Seeder;
use UnixDevil\Crawler\Models\Crawler;
use UnixDevil\Crawler\Models\Feed;

use Winter\Blog\Models\Category;
use Winter\Storm\Database\Updates\Migration;
use Winter\Storm\Support\Facades\Schema;

/**
 * @class SeedCrawlerPlugin
 */
class SeedCrawlerPlugin extends Seeder
{
    protected Generator $faker;

    public function __construct()
    {
        $this->faker = Factory::create('en_GB');
    }

    public function run(): void
    {



        $laravelCrawler = Crawler::create([
            "title" => "Laravel",
            "status" => Crawler::FINISHED
        ]);


        $unixCrawler = Crawler::create([
            "title" => "UnixDevil",
            "status" => Crawler::FINISHED
        ]);


        $securityFeed = Feed::create([
            "title" => "Krebs on Security",
            "description" => $this->faker->paragraph(3),
            'score' => $this->faker->randomDigit(),
            'subscribers' => $this->faker->randomDigit(),
            'url' => 'https://krebsonsecurity.com/feed/'
        ]);

        $laraFeed = Feed::create([
            "title" => "Laravel News",
            "description" => $this->faker->paragraph(3),
            'score' => $this->faker->randomDigit(),
            'subscribers' => $this->faker->randomDigit(),
            'url' => 'https://laravel-news.com/feed'
        ]);


        $lzoMedia = Website::create([
            "name" => "LzoMedia",
            "url" => 'https://lzomedia.com',
            "username" => "admin",
            'password' => "garcelino87",
        ]);

        $unixDevil = Website::create([
            "name" => "UnixDevil",
            "url" => 'https://unixdevil.com',
            "username" => "admin",
            'password' => "garcelino87",
        ]);


        $laravelCrawler->feeds()->save($laraFeed);
        $unixCrawler->feeds()->save($securityFeed);

        $category = (new \Winter\Blog\Models\Category)->get()->first();

        $securityFeed->categories()->attach($category);
        $securityFeed->websites()->attach($unixDevil);

        $laraFeed->categories()->attach($category);
        $laraFeed->websites()->attach($lzoMedia);
    }
}
