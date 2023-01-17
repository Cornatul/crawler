<?php namespace UnixDevil\Crawler;


use Backend\Facades\Backend;
use Controller;
use Illuminate\Support\Facades\Event;
use UnixDevil\Crawler\Clients\NLPClient;
use UnixDevil\Crawler\Contracts\FeedContract;
use UnixDevil\Crawler\Contracts\FeedFinderContract;
use UnixDevil\Crawler\Contracts\NLPContract;
use UnixDevil\Crawler\FormWidgets\WordpressPublish;
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
     * @return string[]
     */
    public function pluginDetails(): array
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
                ]
            ]
        ];
    }


    final public function register(): void
    {
        $this->app->bind(FeedFinderContract::class, FeedFinderService::class);
        $this->app->bind(FeedContract::class, FeedRepository::class);
        $this->app->bind(NLPContract::class, NLPClient::class);
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
