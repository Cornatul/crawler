<?php namespace UnixDevil\Crawler;

use Backend\Facades\Backend;
use Backend\Classes\Controller;
use GuzzleHttp\Client;
use GuzzleHttp\ClientInterface;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Event;

use UnixDevil\Crawler\Clients\SentimentClient;
use UnixDevil\Crawler\Clients\TrendingClient;
use UnixDevil\Crawler\Clients\WordpressClient;
use UnixDevil\Crawler\Console\ClearEventLogs;
use UnixDevil\Crawler\Console\HtmlExtractor;
use UnixDevil\Crawler\Console\PythonPublisher;
use UnixDevil\Crawler\Contracts\FeedContract;
use UnixDevil\Crawler\Contracts\FeedFinderContract;

use UnixDevil\Crawler\Contracts\SentimentContract;
use UnixDevil\Crawler\Contracts\TrendingContract;
use UnixDevil\Crawler\Contracts\WordpressContract;
use UnixDevil\Crawler\FormWidgets\WordpressPublish;
use UnixDevil\Crawler\Jobs\PublishPython;
use UnixDevil\Crawler\ReportWidgets\TrendingKeywords;
use UnixDevil\Crawler\ReportWidgets\TrendingNews;
use UnixDevil\Crawler\Repositories\FeedRepository;
use UnixDevil\Crawler\Services\FeedFinderService;
use System\Classes\PluginBase;
use Winter\Blog\Classes\TagProcessor;
use Winter\Blog\Models\Category;

/**
 * @class Plugin
 */
class Plugin extends PluginBase
{

    /**
     * @var array Plugin dependencies
     */
    public $require = ['Winter.Blog'];

    /**
     * @return string[]
     */
    final public function pluginDetails(): array
    {
        return [
            'name'        => 'Crawler',
            'description' => 'This is the crawler plugin',
            'author'      => 'Unix Devel',
            'icon'        => 'icon-spider',
            'homepage'    => 'https://github.com/UnixDevil/crawler'
        ];
    }

    /**
     * @return array[]
     */
    final public function registerNavigation(): array
    {
        return [
            'crawler' => [
                'label'       => 'Crawlers',
                'url'         => Backend::url('unixdevil/crawler/feed'),
                'icon'        => 'icon-spider',
                'permissions' => ['unixdevil.crawlers.*'],
                'order'       => 400,
                'sideMenu'    => [
                    'feeds' => [
                        'label'       => 'Feeds',
                        'icon'        => 'icon-rss',
                        'url'         => Backend::url('unixdevil/crawler/feed'),
                    ],
                    'feeds-articles' => [
                        'label'       => 'Articles',
                        'icon'        => 'icon-blog',
                        'url'         => Backend::url('unixdevil/crawler/article'),
                    ],
                ]
            ]
        ];
    }


    final public function register(): void
    {

        $this->registerConsoleCommand('crawler.clear', ClearEventLogs::class);
        $this->registerConsoleCommand('crawler.html', HtmlExtractor::class);
        $this->registerConsoleCommand('crawler.publish', PythonPublisher::class);


        $this->app->bind(FeedFinderContract::class, FeedFinderService::class);
        $this->app->bind(FeedContract::class, FeedRepository::class);
        $this->app->bind(SentimentContract::class, SentimentClient::class);
        $this->app->bind(TrendingContract::class, TrendingClient::class);
        $this->app->bind(WordpressContract::class, WordpressClient::class);
        $this->app->bind(ClientInterface::class, Client::class);

        $this->registerCustomValues();
    }


    private function registerCustomValues(): void
    {
            $this->app->when(SentimentClient::class)
            ->needs('$sentimentEndpoint')
            ->give(Config::get('nlp.endpoint.sentiment'));
        $this->app->when(TrendingClient::class)
            ->needs('$trendingEndpoint')
            ->give(Config::get('trending.endpoint'));
    }


    final public function registerFormWidgets(): array
    {
        return [
            WordpressPublish::class => 'wordpress_publish',
        ];
    }

    final public function registerReportWidgets(): array
    {
        return [
            TrendingNews::class => [
                'label'   => 'Trending News',
                'context' => 'dashboard',
                'permissions' => [
                    'unixdevil.crawlers.*',
                ],
            ],
            TrendingKeywords::class => [
                'label'   => 'Trending Keywords',
                'context' => 'dashboard',
                'permissions' => [
                    'unixdevil.crawlers.*',
                ],
            ],
        ];
    }



    final public function boot(): void
    {

        // Extend all backend form usage
        Event::listen('backend.form.extendFields', static function ($widget) {

            // Extend only the Blog\Posts controller
            if (!$widget->getController() instanceof \Winter\Blog\Controllers\Posts) {
                return;
            }

            // Extend only Blog\Post model
            if (!$widget->model instanceof \Winter\Blog\Models\Post) {
                return;
            }

            // Insert the new form widget here that will contain the logic for the WordPress stuff
            $widget->addSecondaryTabFields([
                'wordpress' => [
                    'tab' => 'Publish',
                    'type' => 'wordpress_publish'
                ]
            ]);
        });
    }
}
